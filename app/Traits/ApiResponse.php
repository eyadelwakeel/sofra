<?php

namespace App\Traits;

trait ApiResponse
{
    public function api_response($status,$massage = null,$data=[],$status_code=200){

        $data =[
            'status' => $status,
            'message' => $massage,
            'data' => $data
        ];

        return response()->json($data);
    }

    public function api_data_response($data)
    {
        return $this->api_response('success','',$data);
    }

    public function api_success_massage($massage,$data=[])
    {
        return $this->api_response('success',$massage,$data);
    }
    public function api_error_massage($massage)
    {
        return $this->api_response('error',$massage,[],400);
    }

}
