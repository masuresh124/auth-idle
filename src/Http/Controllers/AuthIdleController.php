<?php

namespace Masuresh124\AuthIdle\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthIdleController extends Controller
{
   public function checkActivity(Request $request){
        $response['status'] = true;
        return response()->json($response);
   }
}
