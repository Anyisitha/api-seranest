<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseApi($status, $message = [], $data = [])
    {
        if($message["type"] == "success"){
            $message = $message;
            $message["code"] = 200;
        }else if($message["type"] == "error"){
            $message = $message;
            $message["code"] = 500;
        }else if($message["type"] == "warning"){
            $message = $message;
            $message["code"] = 300;
        }else if($message["type"] == "not found"){
            $message = $message;
            $message["code"] = 404;
        }else{
            abort(500);
        }

        return ["transaction" => ["status" => $status], "message" => $message, "data" => $data];
    }
}
