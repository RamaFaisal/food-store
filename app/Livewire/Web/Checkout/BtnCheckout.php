<?php

namespace App\Livewire\Web\Checkout;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Midtrans\Snap;

class BtnCheckout extends Component
{
    public $provience_id;
    public $city_id;
    public $district_id;
    public $address;

    public $selectCourier;
    public $selectService;
    public $selectCost;

    public $totalWeight;
    public $grandTotal;

    public $response;
    public $loading;

    public function __construct()
    {
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function mount($selectCourier = null, $selectService = null, $selectCost = null)
    {
        $this->selectCourier = $selectCourier;
        $this->selectService = $selectService;
        $this->selectCost = $selectCost;
    }

    public function storeCheckout()
    {
        $this->loading = true;

        $customer = auth()->guard('customer')->user();

        if (!$customer || !$this->provience_id || !$this->city_id || !$this->district_id || !$this->address || !$this->grandTotal) {
            session()->flash('error', 'Data tidak lengkap. Silahkan periksa kembali.');
            return;
        }

        try {
            DB::transaction(function () use ($customer) {
                $invoice = 'INV-' . mt_rand(1000, 9999);

                $transaction = Transaction::create([
                    'customer_id' => $customer->id,
                    'invoice'     => $invoice,
                    'provience_id' => $this->provience_id,
                    'city_id'     => $this->city_id,
                    'district_id' => $this->district_id,
                    'address'     => $this->address,
                    'weight'      => $this->totalWeight,
                    'total'       => $this->grandTotal,
                    'status'      => 'PENDING',
                ]);

                $transaction->shipping()->create([
                    'shipping_courier' => $this->selectCourier,
                    'shipping_service' => $this->selectService,
                    'shipping_cost' => $this->selectCost,
                ]);

                $item_details = [];
                $carts = Cart::where('customer_id', $customer->id)->with('product')->get();

                foreach ($carts as $cart) {
                    $transaction->transactionDetails()->create([
                        'product_id' => $cart->product->id,
                        'qty' => $cart->qty,
                        'price' => $cart->product->price
                    ]);

                    $item_details[] = [
                        'id'       => $cart->product->id,
                        'price'    => $cart->product->price,
                        'quantity' => $cart->qty,
                        'name'     => $cart->product->title,
                    ];
                }
                
                $item_details[] = [
                    'id' => 'shipping',
                    'price' => $this->selectCost,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim ' . $this->selectCourier . ' - ' . $this->selectService,
                ];

                Cart::where('customer_id', $customer->id)->delete();

                $payload = [
                    'transaction_details' => [
                        'order_id' => $invoice,
                        'gross_amount' => $this->grandTotal,
                    ],
                    'customer_details' => [
                        'first_time' => $customer->name,
                        'email' => $customer->email,
                        'shipping_address' => $this->address,
                    ],
                    'item_details' => $item_details,
                ];

                $snapToken = Snap::getSnapToken($payload);

                $transaction->snap_token = $snapToken;
                $transaction->save();

                $this->response['snap_token'] = $snapToken;
                $this->loading = false;
            });

            session()->flash('success', 'Silahkan lakukan pembayaran untuk melanjutkan proses chekcout.');
            return $this->redirect('/account/my-orders/' . $this->response['snap_token'], navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.');

            $this->loading = false;
            return;
        }
    }
    public function render()
    {
        return view('livewire.web.checkout.btn-checkout');
    }
}
