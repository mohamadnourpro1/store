<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\Translation;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Fetch the products in the cart
        $products = $this->products()->get();
        // Calculate the total price
        $totalPrice = $products->sum(function($product) {
            return $product->price;
        });
        return [
          'id'=>$this->id,
          'products' => $this->products()->get()->map(function($product) {
           $s = Product::where('name', $product->name)->first();
           $d = Product::where('description', $product->description)->first();
           $data = [];
           $data['name'] = Translation::where('key',$s->name)->get(['value','language']);
           $data['description'] = Translation::where('key',$d->description)->get(['value','language']);
           $data['price'] = $product->price;
           $data['id']= $product->id;
           return $data;
          }),
          'total_price' => $totalPrice, // Add the total price to the response
          'user'=>$this->user,
        ];
    }
}
