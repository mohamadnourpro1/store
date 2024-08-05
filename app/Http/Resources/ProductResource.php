<?php

namespace App\Http\Resources;

use App\Models\StatuseName;
use App\Models\Translation;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      
        return [
          'id' => $this->id,
          'name' => Translation::where('key',$this->name)->get(['value','language']),
          'description' => Translation::where('key',$this->description)->get(['value','language']),
          'price' => $this->price,
          'images' => $this->image,
          'statuses' => $this->statuse()->get()->map(function($statuse) {
           $s = StatuseName::where('id', $statuse->statuse_name_id)->first();
           return Translation::where('key',$s->name)->get(['value','language']);
          }),
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
        ];
    }
}
