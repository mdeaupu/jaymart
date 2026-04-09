<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Models\Products;
use App\Models\Stocks;

class Pos extends Component
{
    public $search = '';
    public $cart = [];
    public $total = 0;

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

    public function checkout()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang kosong!');
            return;
        }

        foreach ($this->cart as $item) {
            $stock = Stocks::where('product_id', $item['id'])->first();

            if ($stock) {
                $stock->quantity -= $item['qty'];
                $stock->save();
            }
        }

        session()->flash('success', 'Transaksi berhasil!');

        $this->cart = [];
        $this->total = 0;
    }
}