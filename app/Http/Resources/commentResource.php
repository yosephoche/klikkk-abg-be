<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class commentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'owner' => $this->user->nama_lengkap,
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('d MY'),
            'reply' => commentResource::collection($this->replies),
        ];
    }
}
