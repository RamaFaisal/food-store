<?php

namespace App\Livewire\Web\Products;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public $slug;

    public function mount($slug)
    {
        return $this->slug = $slug;
    }

    public function render()
    {
        $product = Product::query()
            ->with('category', 'ratings.customer')
            ->withCount('ratings')
            ->withAvg('ratings', 'rating')
            ->where('slug', $this->slug)
            ->firstOrFail();

        return view('livewire.web.products.show', compact('product'));
    }
}
