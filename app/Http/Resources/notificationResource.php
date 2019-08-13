<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class notificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->data['jenisNotification'] == "Comment")
        {
            return [
                'id' => $this->id,
                'label' => $this->data['jenisNotification'],
                'body' => $this->data['commenter']." Memberi Komentar Pada Thread ". $this->data['judulThread'],  
            ];
        }

        if($this->data['jenisNotification'] == "Reply")
        {
            return [
                'id' => $this->id,
                'typeNotification' => $this->data['jenisNotification'],
                'message' => $this->data['replier']." Memberi Balasan Pada Komentar Anda Pada Thread ".$this->data['judulThread'], 
            ];
        }

    }
}
