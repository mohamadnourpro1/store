<?php

namespace App\Http\Resources;

use App\Models\Translation;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
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
          'status_name'=>Translation::where('key',$this->statuse_name->name)->get(['value','language']),
          'product'=>Translation::where('key',$this->product->name)->get(['value','language']),
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
        ];
    }
}
