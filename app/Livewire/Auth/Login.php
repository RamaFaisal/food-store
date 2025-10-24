<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            "email"=> ["required","email"],
            "password"=> ["required"]
        ];
    }

    public function mount()
    {
        if(auth()->guard('customer')->check()) {
            return $this->redirect('/account/my-orders', navigate: true);
        }
    }

    public function login()
    {
        $this->validate();

        if (auth()->guard('customer')->attempt([
            'email' => $this->email,
            'password' => $this->password,
        ])) {
            session()->flash('success', 'Login Berhasil');

            return $this->redirect('/account/my-orders', navigate: true);
        }

        session()->flash('error', 'Periksa email dan password anda.');

        return $this->redirect('/login', navigate: true);
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
