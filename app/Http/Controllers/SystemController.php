<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function list(){

        $systems = System::all();
        return response()->json($systems);
    }

    public function select(string $id){

        if(intval($id)){
            $system = System::find($id);
            if($system){
                return response()->json($system);
            }else{
                return response()->json(['status' => 'error', 'description' => 'system not found'], 404);
            }
        }else{
            return response()->json(['status' => 'error', 'description' => 'id must be an int value'], 404);
        }
    }

    public function add(Request $request){

        try{
            $result = System::create($request->all());
        }catch (\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return response()->json($errorInfo);
        }
        return response()->json($result->toArray());
    }

    public function update(Request $request){

        $system = System::find($request->get('id'));

        if($system){
            try{
                $system->update($request->all());
            }catch (\Illuminate\Database\QueryException $exception){
                $errorInfo = $exception->errorInfo;
                return response()->json($errorInfo);
            }
            return response()->json($system);
        }else{
            return response()->json(['status' => 'error', 'description' => 'system not found'], 404);
        }
    }

    public function delete(Request $request){

        if(intval($request->get('id'))){
            $system = System::find($request->get('id'));
            if($system){
                $system->delete();
                return response()->json(['status' => 'success', 'description' => 'system deleted']);
            }else{
                return response()->json(['status' => 'error', 'description' => 'system not found'], 404);
            }
        }else{
            return response()->json(['status' => 'error', 'description' => 'id must be an int value'], 404);
        }
    }
}
