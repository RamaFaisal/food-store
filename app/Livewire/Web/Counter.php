<?php

namespace App\Livewire\Web;

use Livewire\Component;

class Counter extends Component
{
    public $counter;
    public $fahrenheit;
    public $celcius;

    public function mount()
    {
        $this->counter = 0;
        $this->fahrenheit = 0;
        $this->celcius = 0;
    }

    public function increment()
    {
        $this->counter++;
    }

    public function decrement()
    {
        $this->counter--;
    }

    public function manipulate()
    {
        $this->counter = $this->counter * $this->counter;
    }

    public function upSuhu()
    {
        $this->celcius = ($this->fahrenheit - 32) * 5 / 9;
    }

    public function update()
    {
        // $this->counter = $this->counter;
    }

    public function render()
    {
        return view('livewire.web.counter');
    }
}
