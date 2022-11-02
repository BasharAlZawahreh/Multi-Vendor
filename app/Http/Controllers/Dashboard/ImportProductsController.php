<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImportProductsController extends Controller
{
    public function create()
    {
        return view('dashboard.products.import');
    }

    public function store()
    {
        $job = new ImportProducts(request()['count']);
        $job->onQueue('import-products');
        //->delay(now()->addSeconds(5));

        $this->dispatch($job);

        return redirect()->route('products.index')
        ->with('success', 'Products are being imported');
    }
}
