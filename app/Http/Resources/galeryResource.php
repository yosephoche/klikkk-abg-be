<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class galeryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->type == "image")
        {
            return [
                'id' => $this->id,
                'file' => url('upload/images/'.$this->file),
            ];
        } else {
            return [
                'id' => $this->id,
                'file' => url('upload/videos/'.$this->file),
            ];
        }
    }
}
