<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
class threadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(Auth::user()->id == $this->created_by)
        {
            $edit_links = route('thread_edit',$this->id);
        } else {
            $edit_links = null;
        }
        return [
            'id' => $this->id,
            'owner' => $this->user->nama_lengkap,
            'category' => $this->category->name,
            'title'=> $this->subject,
            'edit_link' => $edit_links,
            'created_at' => $this->created_at->format('d,M-Y'),
            'comments' => commentResource::collection($this->comments),
            'likesCount' => $this->likesCount,
            'likes' => $this->collectLikers(),
        ];
    }
}
