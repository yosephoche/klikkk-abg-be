<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class answerResource extends JsonResource
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
            'name' => $this->user->nama_lengkap,
            'answer' => $this->answer,
            'reply' => answerResource::collection($this->reply),
        ];
    }
}
