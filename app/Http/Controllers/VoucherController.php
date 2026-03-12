<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Voucher::query();

        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $vouchers = $query->latest()->paginate(10);
        
        return view('vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:20|alpha_dash:ascii',
            'type' => 'required|in:fixed,percentage',
            'amount' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        // Logic cleanup
        if ($validated['type'] === 'percentage' && $validated['amount'] > 100) {
            return back()->withErrors(['amount' => 'Diskon persentase tidak boleh lebih dari 100%.'])->withInput();
        }

        if ($validated['type'] === 'fixed') {
            $validated['max_discount_amount'] = null;
        }

        // Set default start_date if not present (though validation makes it nullable, logic might need it)
        if (empty($validated['start_date'])) {
             $validated['start_date'] = now();
        }
        
        $validated['is_active'] = $request->has('is_active') ? true : true; // Default active on create
        $validated['code'] = strtoupper($validated['code']);

        // Handle Unlimited Quota (If input is disabled/empty, treat as unlimited/null)
        if ($request->missing('quantity') || $request->input('quantity') === null) {
            $validated['quantity'] = null;
        }

        Voucher::create($validated);

        return redirect()->route('vouchers.index')->with('success', 'Voucher berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        return view('vouchers.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'alpha_dash:ascii', Rule::unique('vouchers')->ignore($voucher->id)],
            'type' => 'required|in:fixed,percentage',
            'amount' => 'required|numeric|min:0',
            'min_purchase_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

         // Logic cleanup
         if ($validated['type'] === 'percentage' && $validated['amount'] > 100) {
            return back()->withErrors(['amount' => 'Diskon persentase tidak boleh lebih dari 100%.'])->withInput();
        }

        if ($validated['type'] === 'fixed') {
            $validated['max_discount_amount'] = null;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['code'] = strtoupper($validated['code']);

        // Handle Unlimited Quota
        if ($request->missing('quantity') || $request->input('quantity') === null) {
            $validated['quantity'] = null;
        }

        $voucher->update($validated);

        return redirect()->route('vouchers.index')->with('success', 'Voucher berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Voucher berhasil dihapus.');
    }
}
