<?php

namespace App\Repositories\Traits;


trait forumTrait
{
    public function collectionHttpResponse($response,$data)
    {
        if($response->isNotempty())
        {
            return [
                'response' => $data,
                'diagnostic' => [
                    'code' => 200,
                    'status' => 'ok',
                ]
            ];
        } else {
            return $this->notFound();
        }
    }
    public function notFound()
    {
        return response([
            'message' => 'Not Found',
            'code' => 404
        ],200);
    }
    public function singleHttpResponse($data,$response)
    {
        if(isset($data))
        {   
            return[
                'response' => $response,
                'diagnostic' => [
                    'code' => 200,
                    'status' => 'ok',
                ]
            ];
        } else {
            return $this->notFound();
        }
    }

    public function success()
    {
        return response([
            'message'=>'Success',
            'kode'=>200
        ], 200);
    }

    public function unprocessable()
    {
        return response([
            'message'=>'Unprocessable Request',
            'kode'=>422,
        ], 200);
    }




    public function serverError()
    {
        return response([
            'message'=>'Server Error'
        ], 500);
    }
}