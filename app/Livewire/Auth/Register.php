<?php

namespace App\Livewire\Auth;

use App\Models\Customer;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function rules()
    {
        return [
            'name' => ['required'],
            'email'=> ['required','email', 'unique:customers,email'],
            'password'=> ['required','confirmed'],
        ];
    }

    public function mount()
    {
        if(auth()->guard('customer')->check()) {
            return $this->redirect('/account/my-orders', navigate: true);
        }
    }

    public function register()
    {
        $this->validate();

        Customer::create([
            'name'=> $this->name,
            'email'=> $this->email,
            'password'=> bcrypt($this->password),
        ]);

        session()->flash('success', 'Register Berhasil, Silahkan Login');

        return $this->redirect('/login', navigate: true);
    }
    
    public function render()
    {
        return view('livewire.auth.register');
    }
}
