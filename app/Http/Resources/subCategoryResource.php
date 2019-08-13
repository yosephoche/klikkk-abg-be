<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class subCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $reques t
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parentCategory' => $this->category->name,
            'parentCategoryId' => $this->category->id,
            'name' => $this->name,
            'thread' => threadResource::collection($this->thread),
        ];
    }
}
