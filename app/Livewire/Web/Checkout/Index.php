<?php

namespace App\Livewire\Web\Checkout;

use App\Models\Cart;
use App\Models\Provience;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Index extends Component
{
    public $address;
    public $provience_id;
    public $city_id;
    public $district_id;

    public $loading = false;
    public $showCost = false;
    public $costs;

    public $selectCourier = '';
    public $selectService = '';
    public $selectCost = 0;

    public $grandTotal = 0;

    public function getCartsData()
    {
        $carts = Cart::query()
            ->with('product')
            ->where('customer_id', auth()->guard('customer')->user()->id)
            ->latest()
            ->get();

        $totalWeight = $carts->sum(function ($cart) {
            return $cart->product->weight * $cart->qty;
        });

        $totalPrice = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->qty;
        });

        return [
            'totalWeight' => $totalWeight,
            'totalPrice' => $totalPrice,
        ];
    }

    public function changeCourier($value)
    {
        if (!empty($value)) {
            $this->selectCourier = $value;

            $this->loading = true;

            $this->showCost = false;

            $this->CheckOngkir();
        }
    }

    public function CheckOngkir()
    {
        try {
            $cartData = $this->getCartsData();

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key')
            ])->withOptions([
                'query' => [
                    'origin'      => 59571,
                    'destination' => $this->district_id,
                    'weight'      => $cartData['totalWeight'],
                    'courier'     => $this->selectCourier,
                ]
            ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost');

            $this->costs = $response->json()['data'];
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengambil ongkir: ' . $e->getMessage());
        } finally {
            $this->loading = false;
            $this->showCost = true;
        }
    }

    public function getServiceAndCost($data)
    {
        [$cost, $service] = explode('|', $data);

        $this->selectCost = (int) $cost;
        $this->selectService = $service;

        $cartData = $this->getCartsData();

        $this->grandTotal = $cartData['totalPrice'] + $this->selectCost;
    }

    public function render()
    {
        $proviences = Provience::query()->get();

        $cartData = $this->getCartsData();
        $totalPrice     = $cartData['totalPrice'];
        $totalWeight    = $cartData['totalWeight'];

        return view('livewire.web.checkout.index', compact('proviences', 'totalPrice', 'totalWeight'));
    }
}
