<?php

namespace App\Livewire\Account\Password;

use App\Models\Customer;
use Livewire\Component;

class Index extends Component
{
    public $password;
    public $password_confirmation;

    public function rules()
    {
        return [
            "password"=> "required|confirmed",
        ];
    }

    public function update()
    {
        $this->validate();

        $customer = Customer::where('id', auth()->guard('customer')->user()->id)->first();
        $customer->update([
            'password'=> bcrypt($this->password),
        ]);

        session()->flash('success', 'Update password berhasil');

        return $this->redirect('/account/password', navigate: true);
    }

    public function render()
    {
        return view('livewire.account.password.index');
    }
}
