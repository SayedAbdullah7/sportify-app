<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function handleResponse(string $msg ,$data = [],$status=200)
    {
        $res = [
            'status' => true,
            'msg' => $msg,
            'data' => $data,
            'errors'=>array(),
        ];
        return response()->json($res, 200);

    }

    public function handleError($msg,$errors =[], $status =200)
    {
        if (is_string($errors)) {
             $errors_in_format = [$errors];

        }else{
            $formattedErrors = [];

            foreach ($errors as $key => $value) {
//                $formattedErrors[$key] = $value[0];
                foreach ($value as $v){
                    $formattedErrors[] = ['key'=>$key,'value'=>$v];
                }

            }
        }
//        $formattedErrors = [];
//
//        foreach ($errors as $key => $value) {
//            $formattedErrors[$key] = $value[0];
//        }

        $res =[
            'status' => false,
            'msg' => $msg,
            'data' => array(),
            'errors' => $formattedErrors ,
        ];
        return response()->json($res, $status);
    }
}
