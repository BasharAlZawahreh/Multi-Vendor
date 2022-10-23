<?php

namespace App\View\Components;

use App\Facades\Cart;
use App\Repositories\Cart\CartRepository;
use Illuminate\View\Component;

class CartMenu extends Component
{
    public $items;
    public $total;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CartRepository $cart) // injected CartRepository because its in the service container in the components either
    {
        //using the facade
        $this->items = Cart::get();
        $this->total = Cart::total();

        //using the repo injected in the service container
        // $this->items = $cart->items();
        // $this->total = $cart->total();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-menu');
    }
}
