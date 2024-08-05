<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Statuse;
use Illuminate\Http\Request;

class StatuseController extends Controller
{
  use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuse = Statuse::all();
        return $this->apiresponse(StatusResource::collection($statuse),'all data',200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $statuse = Statuse::create([
          'statuse_name_id'=>$request->statuse_name_id,
          'product_id'=>$request->product_id,
        ]);
        return $this->apiresponse(new StatusResource($statuse),'data saved',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statuse  $statuse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $statuse = Statuse::find($id);
      if ($statuse!=null) {
        return $this->apiresponse(new StatusResource($statuse),'data found',200);
        }
        return $this->apiresponse(null, 'data not found', 404);
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statuse  $statuse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
      $statuse = Statuse::find($id);
      if($statuse!=null){
        $statuse->update([
          'statuse_name_id'=>$request->statuse_name_id,
          'product_id'=>$request->product_id,
          ]);
        return $this->apiresponse(new StatusResource($statuse),'data updated',200);
      }
      return $this->apiresponse(null,'data not found',404);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statuse  $statuse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $statuse = Statuse::find($id);
        if($statuse!=null){
          $statuse->delete();
          return $this->apiresponse(null,'data deleted',200);
        }
        return $this->apiresponse(null,'data not found',404);
    }
}
