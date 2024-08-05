<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusNamesResource;
use App\Models\StatuseName;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StatuseNameController extends Controller
{
  use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = StatuseName::all();
        return $this->apiresponse(StatusNamesResource::collection($status),'all data',200);
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
      $status = StatuseName::create([
        'name'=>$name_t,
      ]);
      if($request->name_ar){
        // ربط الترجمة بالقسم
       Translation::create([
           'key' => $name_t,
           'value' => $request->name_ar,
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
      return $this->apiresponse($status,'data saved',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatuseName  $statuseName
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $status = StatuseName::find($id);
        if($status!=null){
          return $this->apiresponse(new StatusNamesResource($status),"status number $id",200);
        }
        return $this->apiresponse(null,"status number $id not found",404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StatuseName  $statuseName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $status = StatuseName::find($id);
        if($status!=null){
          if($request->name_ar!=null||$request->name_ar!=''){
            Translation::where('key',$status->name)
            ->where('language','ar')->update([
              'value'=>$request->name_ar
            ]);
          }
          if($request->name_en!=null||$request->name_en!=''){
            Translation::where('key',$status->name)
            ->where('language','en')->update([
              'value'=>$request->name_en
              ]);
            }
            return $this->apiresponse(new StatusNamesResource($status),'data updated',200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatuseName  $statuseName
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $status = StatuseName::find($id);
      if($status!=null){
        Translation::where('key',$status->name)->delete();
        $status->delete();
        return $this->apiresponse(null,"status number $id deleted",200);
      }
      return $this->apiresponse(null,"status number $id not found",404);
    }
}
