<?php

namespace App\View\Components;

use App\Services\CurrencyConverter;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class FrontLayout extends Component
{

    public $title;
    // public $currencies;
    public $currency_code;

    public function __construct($title='')
    {
        $api_key = config('services.currency_converter.api_key');

        $this->title = $title ?? config('app.name');
      //  $this->currencies = (new CurrencyConverter($api_key))->allCurrencies();
        $this->currency_code = Session::get('currency_code',config('app.currency','USD'));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.front');
    }
}
