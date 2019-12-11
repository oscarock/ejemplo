<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function init(Request $request){
        var_dump($request->post('city'));

    }
}
