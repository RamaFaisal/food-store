<?php

namespace App\Livewire\Account\MyProfile;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    public $image;
    public $name;
    public $email;

    public function mount()
    {
        $this->name = auth()->guard('customer')->user()->name;
        $this->email = auth()->guard('customer')->user()->email;
    }

    public function rules()
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,'. auth()->guard('customer')->user()->id,
        ];
    }

    public function update()
    {
        $this->validate();
        // dd($this->image);

        if ($this->image) {
            $imageName = $this->image->hashName();
            $this->image->storeAs('avatars', $imageName);

            $profile = Customer::findOrFail(auth()->guard('customer')->user()->id);
            $profile->update([
                'name' => $this->name,
                'email' => $this->email,
                'image' => $imageName
            ]);
        } else {
            $profile = Customer::findOrFail(auth()->guard('customer')->user()->id);
            $profile->update([
                'name' => $this->name,
                'email' => $this->email
            ]);
        };

        session()->flash('success', 'Update profile berhasil');

        return $this->redirect('/account/my-profile', navigate: true);
    }

    public function render()
    {
        return view('livewire.account.my-profile.index');
    }
}
