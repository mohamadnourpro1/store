<?php

namespace App\Http\Resources;

use App\Models\Translation;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusNamesResource extends JsonResource
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
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at
        ];;
    }
}
