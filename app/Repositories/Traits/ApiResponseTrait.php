<?php

namespace App\Repositories\Traits;

/**
 *
 */
trait ApiResponseTrait
{
    public function apiResponse($action, $action_type ='save'){
        try {
            return dtcApiResponse(200, $action, responseMessage($action_type,'success'));
        } catch (\Illuminate\Database\QueryException $th) {
            return databaseExceptionError(implode(', ',$th->errorInfo));
        }
    }
}
