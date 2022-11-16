<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->header('Accept', 'application/json');
        $products= Product::filter(request()->query())
            ->with(
                'category:id,name',
                'store:id,name',
                'tags:id,name'
              )
            ->paginate(10);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

        $user = request()->user();
        if(!$user->tokenCan('products.create')){
            abort(403,'You are not allowed to create products');
        }

        $product = Product::create($request->all());
        return response()->json($product, 201,[
            'Location' => route('products.show', $product->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
        // return $product->load(
        //     'category:id,name',
        //     'store:id,name',
        //     'tags:id,name'
        // );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'sometimes|required|in:active,inactive',
            'compare_price' => 'nullable|numeric|gt:price',
        ]);

        $user = request()->user();
        if(!$user->tokenCan('products.update')){
            return response([
                'message'=>'You are not allowed to delete products'
            ],403);
        }

        $product->update($request->all());
        return response()->json($product, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = request()->user();
        if(!$user->tokenCan('products.delete')){
            abort(403,'You are not allowed to delete products');
        }
        
        Product::destroy($id);
        return response()->json([
            'message' => 'Product deleted successfully'
        ], 204); // 204 No Content
    }
}
