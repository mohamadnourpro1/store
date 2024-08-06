<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Translation;
use Illuminate\Http\Request;

class CartController extends Controller
{
  use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::all();
        return $this->apiresponse(CartResource::collection($cart),'all data',200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    public function mycart(){
      $cart = Cart::where('user_id',auth()->user()->id)->with('products')->get(); 
      return $this->apiresponse(CartResource::collection($cart),'my cart',200);
    }

    public function deltemyproducts(){
      $cart = Cart::where('user_id', auth()->user()->id)->first();
      $cart->products()->detach();
      return $this->apiresponse($cart,'delete my products',200);
    }

    public function ordermyproducts(Request $request)
    {
      
        // الحصول على جميع العربات للمستخدم الحالي مع المنتجات المرتبطة
        $cart = Cart::where('user_id', auth()->user()->id)->with('products')->get();
    
        // إنشاء مصفوفة لتخزين معلومات المنتجات
        $productsData = [];
    
        // حساب إجمالي السعر وتجميع بيانات المنتجات
        $totalPrice = $cart->sum(function ($cartItem) use (&$productsData) {
            return $cartItem->products->sum(function ($product) use (&$productsData) {
                $productsData[] = [
                    'id' => $product->id,
                    // 'name_ar' => Translation::where('key',$product->name)
                    // ->where('language','ar')
                    // ->pluck('value')
                    // ->first(),
                    // 'name_en' => Translation::where('key',$product->name)
                    // ->where('language','en')
                    // ->pluck('value')
                    // ->first(),
                    'name'=>$product->name,
                    'price' => $product->price
                ];
                return $product->price;
            });
        });
    
        // إعداد الاستجابة مع بيانات المنتجات وإجمالي السعر
        $response = [
            'total_price' => $totalPrice,
            'products' => $productsData
        ];
        $order = Order::create([
          'name'=>auth()->user()->name,
          'email'=>auth()->user()->email,
          'location_name'=>$request->location_name,
          'location'=>$request->location,
          'phone'=>$request->phone,
          'total_price'=>$totalPrice,
        ]);
         foreach($productsData as $pr){
          OrderProduct::create([
            'order_id'=>$order->id,
            'name'=>$pr['name'],
            'price'=>$pr['price'],
            'id_product'=>$pr['id'],
          ]);
         }
         $cart = Cart::where('user_id', auth()->user()->id)->first();
         $cart->products()->detach();
        
    
        // إعادة الاستجابة
        return $this->apiresponse($response, 'Order my products', 200);
    }
    


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
