<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Products;
use App\Models\Stocks;
use App\Models\Transactions;
use App\Models\TransactionsDetail;
use Illuminate\Support\Facades\DB;

class Pos extends Component
{
    public $search = '';
    public $cart = [];
    

    public function addToCart($id)
    {
        $product = Products::with('stock')->find($id);

        if (!$product) {
            return;
        }

        $stock = $product->stock->quantity ?? 0;
        $currentQty = $this->cart[$id]['qty'] ?? 0;

        if ($currentQty >= $stock) {
            session()->flash('error', 'Stok habis!');
            return;
        }

        if (isset($this->cart[$id])) {
            $this->cart[$id]['qty']++;
        } else {
            $this->cart[$id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->sell_price,
                'qty'   => 1,
            ];
        }

        $this->calculateTotal();
    }

    public function decreaseQty($id)
    {
        if (isset($this->cart[$id])) {
            $this->cart[$id]['qty']--;

            if ($this->cart[$id]['qty'] <= 0) {
                unset($this->cart[$id]);
            }
        }

        $this->calculateTotal();
    }
    public function getTotalProperty()
{
    return collect($this->cart)->sum(function ($item) {
        return $item['price'] * $item['qty'];
    });
}

    public function removeItem($id)
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
        }

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });
    }

    public function render()
    {
        $products = Products::with('stock')
            ->where('name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.cashier.pos', [
            'products' => $products,
        ])->layout('layouts.app');
    }

    public function increaseQty($id)
{
    $this->cart[$id]['qty']++;
}



public function removeFromCart($id)
{
    unset($this->cart[$id]);
}

public function checkout()
{
    $transaction = null;

DB::transaction(function () use (&$transaction) {

    $transaction = Transactions::create([
        'branch_id' => auth()->user()->branch_id,
        'user_id' => auth()->id(),
        'total_price' => $this->total,
        'shift' => $this->getShift()

    ]);

    foreach ($this->cart as $item) {

        TransactionsDetail::create([
    'transaction_id' => $transaction->id,
    'product_id' => $item['id'],
    'qty' => $item['qty'],
    'price_at_transaction' => $item['price'],
]);

        $stock = Stocks::where('product_id', $item['id'])->first();
        $stock->quantity -= $item['qty'];
        $stock->save();
    }

    $this->cart = [];
});

session()->flash('success', 'Transaksi berhasil!');

return redirect()->route('cashier.receipt', $transaction->id);
}

public function getShift()
{
    $hour = now()->format('H');

    if ($hour >= 6 && $hour < 14) return 'Pagi';
    if ($hour >= 14 && $hour < 22) return 'Siang';
    return 'Malam';
}
}