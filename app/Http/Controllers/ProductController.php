<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all products with pagination 
        $products = Product::paginate(4); // paginate(4) -> 4 records 
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate products fields
        $request->validate([
            'name' => 'filled|string|max: 255',
            'description' => 'required',
            'price' => 'required',
        ]);

        // create instance
        $products = new Product();
        $products->name = $request->input('name');
        $products->description = $request->input('description');
        $products->price = $request->input('price');

        // save the products
        $products->save();

        // return the products on json format
        return response()->json($products, 200);

        // Another way to store data by using create function and $request->all()
        /*  return Product::create($request->all());  */
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product || endpoint http://127.0.0.1:800/api/products/{product}
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
        $getSingleProduct = Product::find($product);  // findorfail() || find()

        //check if id is not existing
        if (is_null($getSingleProduct)) {
            return response()->json(['message' => 'Product not found!'], 404);
        } else {
            return response()->json($getSingleProduct, 200);
        }

        // Another way to call single product
        /* return Product::findorfail($product); */
    }
}
