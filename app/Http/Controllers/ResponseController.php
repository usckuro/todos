<?php
/**
 * Created by PhpStorm.
 * User: usckuro
 * Date: 7/09/18
 * Time: 12:06 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ResponseController extends Controller
{
    public function Response($data = [], $headers = [])
    {
        return Response()->json($data, 200)->withHeaders($headers);
    }


    public function CustomError($message = '', $headers = [])
    {
        $response = (new Response(['message' => $message], 400))->withHeaders($headers);
        return $response;
    }
}