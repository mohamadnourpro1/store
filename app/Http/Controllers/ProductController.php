<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
  use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return $this->apiresponse(ProductResource::collection($products),'all data',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $name_t = Str::uuid();
         $description_t = Str::uuid();
         $product = Product::create([
          'name'=>$name_t,
          'description'=>$description_t,
          'price'=>$request->price,
         ]);
         if($request->name_ar){
          // ربط الترجمة بالقسم
         Translation::create([
             'key' => $name_t,
             'value' => $request->name_ar,
             'language' => 'ar'
         ]);
     }
     if($request->description_ar){
         // ربط الترجمة بالقسم
         Translation::create([
             'key' => $description_t,
             'value' => $request->description_ar,
             'language' => 'ar'
         ]);
     }

     if($request->name_en){
         // ربط الترجمة بالقسم
        Translation::create([
            'key' => $name_t,
            'value' => $request->name_en,
            'language' => 'en'
        ]);
    }
    if($request->description_en){
        // ربط الترجمة بالقسم
        Translation::create([
            'key' => $description_t,
            'value' => $request->description_en,
            'language' => 'en'
        ]);
    }
    Image::create([
      'product_id'=>$product->id,
      'image1'=>$request->image1,
      'image2'=>$request->image2,
      'video'=>$request->video,
    ]);

    return $this->apiresponse($product,'data saved',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if($product!=null){
          return $this->apiresponse(new ProductResource($product),"product number $id",200);
        }
        return $this->apiresponse(null,"product not found",404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $product = Product::find($id);
        if($product!=null){
          if($request->name_ar!=null||$request->name_ar!=''){
            Translation::where('key',$product->name)
            ->where('language','ar')->update([
              'value'=>$request->name_ar
            ]);
          }
          if($request->name_en!=null||$request->name_en!=''){
            Translation::where('key',$product->name)
            ->where('language','en')->update([
              'value'=>$request->name_en
              ]);
            }

          if($request->description_ar!=null||$request->description_ar!=''){
                Translation::where('key',$product->description)
                ->where('language','ar')->update([
                  'value'=>$request->description_ar
                ]);
              }
          if($request->description_en!=null||$request->description_en!=''){
                Translation::where('key',$product->description)
                ->where('language','en')->update([
                  'value'=>$request->description_en
                  ]);
           }
           if($request->price!=null){
            $product->update([
              'price'=>$request->price,
             ]);
           }
           $product->image->update([
            'image1'=>$request->image1,
            'image2'=>$request->image2,
            'video'=>$request->video,
          ]);
            return $this->apiresponse(new ProductResource($product),'data updated',200);
          }
          return $this->apiresponse(null,'data not found',404);
          
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $product = Product::find($id);
      if($product!=null){
        Translation::where('key',$product->name)->delete();
        Translation::where('key',$product->description)->delete();
        $product->image->delete();
        $product->delete();
        return $this->apiresponse(null,'data deleted',200);
      }
      return $this->apiresponse(null,'data not found',404);
    }
}
