<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
  use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->apiresponse(CategoryResource::collection($categories),'all data',200);
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
        $category = Category::create(
          [
            'name'=>$name_t,
            'description'=>$description_t,
          ]
          );
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
          return $this->apiresponse($category,'data saved',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $category = Category::find($id);
        if($category!=null){
          if($request->name_ar!=null||$request->name_ar!=''){
            Translation::where('key',$category->name)
            ->where('language','ar')->update([
              'value'=>$request->name_ar
            ]);
          }
          if($request->name_en!=null||$request->name_en!=''){
            Translation::where('key',$category->name)
            ->where('language','en')->update([
              'value'=>$request->name_en
              ]);
            }

          if($request->description_ar!=null||$request->description_ar!=''){
                Translation::where('key',$category->description)
                ->where('language','ar')->update([
                  'value'=>$request->description_ar
                ]);
              }
          if($request->description_en!=null||$request->description_en!=''){
                Translation::where('key',$category->description)
                ->where('language','en')->update([
                  'value'=>$request->description_en
                  ]);
           }
          return $this->apiresponse($category,'data updated',200);
        }
        return $this->apiresponse(null,'data not found',404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category!=null){
          Translation::where('key',$category->name)->delete();
          Translation::where('key',$category->description)->delete();
          $category->delete();
          return $this->apiresponse(null,'data deleted',200);
          }
          return $this->apiresponse(null,'data not found',404);
    }
}
