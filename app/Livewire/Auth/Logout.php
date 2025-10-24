<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        auth()->guard('customer')->logout();

        session()->flash('success','Logout Berhasil');

        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
