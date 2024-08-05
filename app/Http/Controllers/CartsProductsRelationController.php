<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartsProductsRelation;
use App\Models\User;
use Illuminate\Http\Request;

class CartsProductsRelationController extends Controller
{
  use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $carts = CartsProductsRelation::create([
          'cart_id' => auth()->user()->cart->id,
          'product_id' => $request->product_id,
         ]);
         return $this->apiresponse($carts,'data saved',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartsProductsRelation  $cartsProductsRelation
     * @return \Illuminate\Http\Response
     */
    public function show(CartsProductsRelation $cartsProductsRelation)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartsProductsRelation  $cartsProductsRelation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartsProductsRelation $cartsProductsRelation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartsProductsRelation  $cartsProductsRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartsProductsRelation $cartsProductsRelation)
    {
        //
    }
}
