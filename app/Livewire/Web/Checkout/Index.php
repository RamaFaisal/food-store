<?php

namespace App\Livewire\Web\Checkout;

use App\Models\Provience;
use Livewire\Component;

class Index extends Component
{
    public $address;
    public $provience_id;
    public $city_id;
    public $district_id;

    public function render()
    {
        $proviences = Provience::query()->get();
        return view('livewire.web.checkout.index', compact('proviences'));
    }
}
