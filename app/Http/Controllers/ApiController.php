<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function list(Request $request){

        //db connection check
        $db = \DB::connection();
        dd($db);
        return 'db init';
    }
}
