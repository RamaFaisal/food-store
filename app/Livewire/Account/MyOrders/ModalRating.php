<?php

namespace App\Livewire\Account\MyOrders;

use App\Models\Rating;
use Livewire\Component;

class ModalRating extends Component
{
    public $transaction;
    public $item;

    public $rating;
    public $review;

    public function rules()
    {
        return [
            'rating' => 'require|in:1,2,3,4,5',
            'review' => 'required',
        ];
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }


    public function storeRating()
    {
        $this->validate();

        $check_rating = Rating::query()
            ->where('product_id', $this->item->product->id)
            ->where('customer_id', auth()->guard('customer')->user()->id)
            ->first();
        
        if ($check_rating) {
            session()->flash('warning', 'Anda sudah pernah memberikan rating untuk produk ini');
            return $this->redirect('/account/my-orders/'.$this->transaction->snap_token, navigate: true);
        }

        Rating::create([
            'transaction_detail_id' => $this->item->id,
            'product_id' => $this->item->product->id,
            'rating' => $this->rating,
            'review' => $this->review,
            'customer_id' => auth()->guard('customer')->user()->id
        ]);

        session()->flash('success','Rating berhasil disimpan');

        return $this->redirect('/account/my-orders/'.$this->transaction->snap_token, navigate: true);
    }

    public function render()
    {
        return view('livewire.account.my-orders.modal-rating');
    }
}
