<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function list(){

        $phones = Phone::with('processor','manufacturer','system')->get();
        $result = [];

        foreach($phones as $phone){
            $result[] = $phone;
        }

        return response()->json($result);
    }

    public function select(string $id){

        if(intval($id)){
            $phone = Phone::with('processor','manufacturer','system')->where('id','=',$id)->get();

            if($phone){
                return response()->json($phone);
            }else{
                return response()->json(['status' => 'error', 'description' => 'phone not found'], 404);
            }
        }else{
            return response()->json(['status' => 'error', 'description' => 'id must be an int value'], 404);
        }
    }

    public function add(Request $request){

        try{
            $result = Phone::create($request->all());
        }catch (\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return response()->json($errorInfo);
        }
        return response()->json($result->toArray());
    }

    public function update(Request $request){

        $phone = Phone::find($request->get('id'));

        if($phone){
            try{
                $phone->update($request->all());
            }catch (\Illuminate\Database\QueryException $exception){
                $errorInfo = $exception->errorInfo;
                return response()->json($errorInfo);
            }
            return response()->json($phone);
        }else{
            return response()->json(['status' => 'error', 'description' => 'phone not found'], 404);
        }
    }

    public function delete(Request $request){

        if(intval($request->get('id'))){
            $phone = Phone::find($request->get('id'));
            if($phone){
                $phone->delete();
                return response()->json(['status' => 'success', 'description' => 'phone deleted']);
            }else{
                return response()->json(['status' => 'error', 'description' => 'phone not found'], 404);
            }
        }else{
            return response()->json(['status' => 'error', 'description' => 'id must be an int value'], 404);
        }
    }
}
