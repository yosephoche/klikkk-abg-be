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

    public function noPaging($response,$data)
    {
        if($response->isNotempty())
        {
            return [
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
        return dtcApiResponse(200,null,'Empty Result');
    }

    public function unauthorized()
    {
        return dtcApiResponse(401,null,'Unatuhorized');

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

    public function successGalery($filename){
        return dtcApiResponse(200, url('upload/images/'.$filename),'Success');
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
        return dtcApiResponse(500,null,'Unprocessable Process');
    }




    public function serverError()
    {
        return dtcApiResponse(500,null,'Server Error');        
    }
}