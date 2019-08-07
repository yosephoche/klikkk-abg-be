<?php

namespace App\Repositories\Traits;


trait forumTrait
{
    public function collectionHttpResponse($response,$data)
    {
        if($response->isNotempty())
        {
            return [
                'pagination' => [
                    'total' => $data->total(),
                    'count' => $data->count(),
                    'perPage' => $data->perPage(),
                    'currentPage' => $data->currentPage(),
                    'totalPages' => $data->lastPage(),
                ],
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

    public function notFound()
    {
        return response([
            'message' => 'Not Found',
            'code' => 404
        ],200);
    }

    public function unauthorized()
    {
        return response([
            'message' => 'Unauthorized',
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
        // return response([
        //     'message'=>'Success',
        //     'kode'=>200
        // ], 200);

        return dtcApiResponse(200,null,'Success');
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