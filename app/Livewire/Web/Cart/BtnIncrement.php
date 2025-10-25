<?php

namespace App\Livewire\Web\Cart;

use App\Models\Cart;
use Livewire\Component;

class BtnIncrement extends Component
{
    public $cart_id;
    public $product_id;

    public function mount($cart_id, $product_id)
    {
        $this->cart_id = $cart_id;
        $this->product_id = $product_id;
    }

    public function increment()
    {
        $cart = Cart::find($this->cart_id);
        $cart->increment('qty');

        session()->flash('success','Qty Keranjang berhasil ditambahkan');

        return $this->redirect('/cart', navigate: true);
    }
    public function render()
    {
        return view('livewire.web.cart.btn-increment');
    }
}
