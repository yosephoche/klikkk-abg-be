<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QnAResource extends JsonResource
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
            'question' => $this->question,
            'answer' => answerResource::collection($this->answers),
            'created_at' => $this->created_at->format('d,M-Y'),
        ];
    }
}
