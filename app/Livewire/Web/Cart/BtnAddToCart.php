<?php

namespace App\Livewire\Web\Cart;

use App\Models\Cart;
use Livewire\Component;

class BtnAddToCart extends Component
{
    public $product_id;

    public function addToCart()
    {
        if (!auth()->guard('customer')->check()) {
            session()->flash('warning','Silahkan login terlebih dahulu');
            return $this->redirect('/login', navigate: true);
        }

        $item = Cart::where('product_id', $this->product_id)
                    ->where('customer_id', auth()->guard('customer')->user()->id)
                    ->first();

        if ($item) {
            $item->increment('qty');
        } else {
            $item = Cart::create([
                'customer_id' => auth()->guard('customer')->user()->id,
                'product_id' => $this->product_id,
                'qty' => 1
            ]);
        }

        session()->flash('success', 'Produk berhasil ditambahakan ke keranjang');

        return $this->redirect('/cart', navigate: true);
    }
    public function render()
    {
        return view('livewire.web.cart.btn-add-to-cart');
    }
}