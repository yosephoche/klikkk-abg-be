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
        if ($this->liked)
        {
            $likeStatus = True;
        } else {
            $likeStatus = False;
        }
        return [
            'id' => $this->id,
            'owner' => $this->user->nama_lengkap,
            'avatar' => userAvatar($this->user->avatar),
            'comment' => $this->comment,
            'images' => galeryResource::collection($this->galery->where('type','image')),
            'videos' => galeryResource::collection($this->galery->where('type','video')),
            'created_at' => $this->created_at->format('d MY'),
            'reply' => commentResource::collection($this->replies),
            'likesCount' => $this->likesCount,
            'likes' => $this->collectLikers(),
            'likeStatus' => $likeStatus,
        ];
    }
}
