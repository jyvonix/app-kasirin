<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Voucher;
use App\Models\Category; // Import Category
use App\Models\Setting; // Import Setting Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = (string) config('services.midtrans.server_key');
        // Pastikan is_production adalah boolean murni
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');

        if (empty(Config::$serverKey)) {
            \Log::error('Midtrans Server Key is empty. Check your .env file.');
        }
    }

    public function index()
    {
        // Ambil produk yang stoknya > 0
        $products = Product::where('stock', '>', 0)->get();
        
        // Ambil semua kategori untuk filter
        $categories = Category::all();
        
        // Ambil setting pajak, default 0 jika belum diset
        $taxRate = Setting::where('key', 'tax_rate')->value('value') ?? 0;
        
        return view('transactions.index', compact('products', 'categories', 'taxRate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,midtrans', // cash or midtrans
            'cash_amount' => 'nullable|numeric|min:0',
            'voucher_code' => 'nullable|string|exists:vouchers,code',
        ]);

        try {
            DB::beginTransaction();

            // 1. Hitung Total Sebenarnya (Server-Side Calculation)
            $subtotal = 0;
            $items = [];

            foreach ($request->cart as $cartItem) {
                $product = Product::lockForUpdate()->find($cartItem['id']); // Lock baris biar gak rebutan stok
                
                if ($product->stock < $cartItem['qty']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi! Sisa: {$product->stock}");
                }

                $subtotal += $product->price * $cartItem['qty'];
                
                $items[] = [
                    'product' => $product,
                    'qty' => $cartItem['qty'],
                    'price' => $product->price
                ];
            }

            // 2. Hitung Diskon Voucher
            $discountAmount = 0;
            $voucher = null;

            if ($request->voucher_code) {
                $voucher = Voucher::where('code', $request->voucher_code)->first();
                if ($voucher && $voucher->isValidFor($subtotal)) {
                    if ($voucher->type == 'fixed') {
                        $discountAmount = $voucher->amount;
                    } else {
                        $discountAmount = $subtotal * ($voucher->amount / 100);
                        if ($voucher->max_discount_amount) {
                            $discountAmount = min($discountAmount, $voucher->max_discount_amount);
                        }
                    }
                    
                    // Increment usage later
                }
            }

            // 3. Pajak (Ambil dari Database)
            $taxRateSetting = Setting::where('key', 'tax_rate')->value('value') ?? 0;
            $taxRateDecimal = $taxRateSetting / 100; // Ubah persen (misal 11) jadi desimal (0.11)
            
            $taxableAmount = max(0, $subtotal - $discountAmount);
            $taxAmount = $taxableAmount * $taxRateDecimal;
            
            // PENTING: Round total agar tidak ada koma (Midtrans butuh integer bersih)
            $grandTotal = round($taxableAmount + $taxAmount);
            if ($grandTotal < 0) $grandTotal = 0;

            // 4. Validasi Pembayaran
            $paymentStatus = 'pending';
            $snapToken = null;
            $changeAmount = 0;
            $cashAmount = 0;

            if ($request->payment_method === 'cash') {
                if ($request->cash_amount < $grandTotal) {
                    throw new \Exception("Uang tunai kurang!");
                }
                $cashAmount = $request->cash_amount;
                $changeAmount = $cashAmount - $grandTotal;
                $paymentStatus = 'paid';
            }

            // 5. Buat Transaksi
            $invoiceCode = 'INV-' . date('YmdHis') . '-' . rand(100, 999);
            
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'voucher_id' => $voucher ? $voucher->id : null,
                'invoice_code' => $invoiceCode,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total_price' => $grandTotal,
                'cash_amount' => $cashAmount,
                'change_amount' => $changeAmount,
                'payment_type' => $request->payment_method,
                'payment_status' => $paymentStatus,
            ]);

            // 6. Simpan Detail & Update Stok
            foreach ($items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                ]);

                $item['product']->decrement('stock', $item['qty']);
            }

            // 7. Update Voucher Used Count
            if ($voucher) {
                $voucher->increment('used_count');
            }

            // 8. Handle Midtrans
            if ($request->payment_method === 'midtrans') {
                $params = [
                    'transaction_details' => [
                        'order_id' => $invoiceCode,
                        'gross_amount' => (int) $grandTotal, // Midtrans butuh integer
                    ],
                    'customer_details' => [
                        'first_name' => 'Pelanggan',
                        'last_name' => 'Umum',
                        'email' => 'pelanggan@example.com',
                        'phone' => '081234567890',
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
                $transaction->update(['snap_token' => $snapToken]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi Dibuat!',
                'transaction' => $transaction,
                'snap_token' => $snapToken // Frontend pakai ini utk popup
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Endpoint untuk cek status voucher valid/tidak via AJAX
     */
    public function checkVoucher(Request $request) 
    {
        $code = $request->code;
        $total = $request->total;

        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return response()->json(['valid' => false, 'message' => 'Kode tidak ditemukan']);
        }

        // Detail validasi agar pesan lebih jelas
        if (!$voucher->is_active) {
            return response()->json(['valid' => false, 'message' => 'Voucher dinonaktifkan']);
        }

        $now = \Illuminate\Support\Carbon::now();
        if ($voucher->start_date && $now->lt($voucher->start_date)) {
            return response()->json(['valid' => false, 'message' => 'Voucher belum mulai berlaku']);
        }

        if ($voucher->end_date && $now->gt($voucher->end_date)) {
            return response()->json(['valid' => false, 'message' => 'Voucher sudah kadaluwarsa']);
        }

        if ($voucher->quantity !== null && $voucher->used_count >= $voucher->quantity) {
            return response()->json(['valid' => false, 'message' => 'Kuota voucher habis']);
        }

        if ($total < $voucher->min_purchase_amount) {
            return response()->json(['valid' => false, 'message' => 'Min. belanja Rp ' . number_format($voucher->min_purchase_amount, 0, ',', '.')]);
        }

        // Kalkulasi simulasi diskon
        $discount = 0;
        if ($voucher->type == 'fixed') {
            $discount = $voucher->amount;
        } else {
            $discount = $total * ($voucher->amount / 100);
            if ($voucher->max_discount_amount) {
                $discount = min($discount, $voucher->max_discount_amount);
            }
        }

        return response()->json([
            'valid' => true,
            'discount_amount' => $discount,
            'message' => 'Voucher berhasil diterapkan!'
        ]);
    }

    /**
     * Endpoint dipanggil setelah pembayaran Midtrans sukses
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        // Terima 'success' atau 'paid'
        if ($request->status == 'success' || $request->status == 'paid') {
            $transaction->update(['payment_status' => 'paid']);
            return response()->json(['message' => 'Status updated to PAID']);
        }
        
        return response()->json(['message' => 'Ignored', 'received' => $request->status]);
    }

    public function history()
    {
        $transactions = Transaction::with('user')->latest()->paginate(10);
        return view('transactions.history', compact('transactions'));
    }

    public function print(Transaction $transaction)
    {
        $shopName = Setting::where('key', 'shop_name')->value('value') ?? 'KASIRIN MART';
        $shopAddress = Setting::where('key', 'shop_address')->value('value') ?? 'Jl. Merdeka No. 45';
        
        return view('transactions.print', compact('transaction', 'shopName', 'shopAddress'));
    }

    public function show(Transaction $transaction)
    {
        // Load relationship details & product
        $transaction->load(['details.product', 'user']);
        
        return response()->json([
            'invoice_code' => $transaction->invoice_code,
            'date' => $transaction->created_at->format('d M Y, H:i'),
            'cashier' => $transaction->user ? $transaction->user->name : 'Kasir Tidak Diketahui',
            'payment_type' => $transaction->payment_type,
            'payment_status' => $transaction->payment_status,
            'subtotal' => (float) $transaction->subtotal,
            'discount' => (float) $transaction->discount_amount,
            'tax' => (float) $transaction->tax_amount,
            'total' => (float) $transaction->total_price,
            'cash' => (float) $transaction->cash_amount,
            'change' => (float) $transaction->change_amount,
            'snap_token' => $transaction->snap_token, // Kirim token untuk bayar ulang
            'items' => $transaction->details->map(function($item) {
                return [
                    'name' => $item->product ? $item->product->name : 'Produk Dihapus',
                    'qty' => $item->quantity,
                    'price' => (float) $item->price,
                    'subtotal' => $item->quantity * $item->price
                ];
            }),
            'print_url' => route('transactions.print', $transaction->id)
        ]);
    }
}
