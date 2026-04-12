<?php

namespace App\Livewire\Manager;

use App\Models\Products;
use App\Models\StockAdjustments;
use App\Models\Stocks;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StockAdjustmentCreate extends Component
{
    public $product_id;
    public $branch_id;
    public $adjustment_amount;
    public $reason;
    public $current_stock = 0;

    protected function rules()
    {
        return [
            'product_id' => [
                'required',
                'exists:products,id',
                function ($attribute, $value, $fail) {
                    $existsInBranch = Stocks::where('branch_id', $this->branch_id)
                        ->where('product_id', $value)
                        ->exists();

                    if (!$existsInBranch) {
                        $fail('Produk ini tidak terdaftar di cabang Anda.');
                    }
                },
            ],
            'adjustment_amount' => 'required|numeric|not_in:0',
            'reason' => 'required|string|min:5',
        ];
    }

    public function mount()
    {
        $this->branch_id = Auth::user()->branch_id;
    }

    public function updatedProductId($value)
    {
        $stock = Stocks::where('branch_id', $this->branch_id)
            ->where('product_id', $value)
            ->first();

        $this->current_stock = $stock ? $stock->quantity : 0;
    }

    public function submitAdjustment()
    {
        $this->validate();
        $newQuantity = $this->current_stock + $this->adjustment_amount;

        StockAdjustments::create([
            'branch_id' => $this->branch_id,
            'product_id' => $this->product_id,
            'user_id' => auth()->id(),
            'old_quantity' => $this->current_stock,
            'adjustment_amount' => $this->adjustment_amount,
            'new_quantity' => $newQuantity,
            'reason' => $this->reason,
            'status' => 'pending',
        ]);

        session()->flash('message', 'Pengajuan penyesuaian stok berhasil dikirim.');
        return redirect()->route('manager.stockadjustmentcreate');
    }

    public function render()
    {
        return view('livewire.manager.stock-adjustment-create', [
            'products' => Products::whereHas('stocks', function ($query) {
                $query->where('branch_id', $this->branch_id);
            })->orderBy('name')->get()
        ])->layout('layouts.app');
    }
}
