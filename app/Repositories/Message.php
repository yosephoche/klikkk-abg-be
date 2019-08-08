<?php

namespace App\Repositories;

class Message
{

    protected $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function index()
    {
        $message = $this->user->unreadNotifications()->get()->where('data.type','message')->sortByDesc('created_at')->map(function($value){
            return [
                'tanggal' => prettyDate($value->created_at),
                'label' => $value->data['label'],
                'body' => $value->data['body'],
                'path' => isset($value->data['path'])?$value->data['path']:null,
            ];
        });

        return $message->toArray();

    }
}
