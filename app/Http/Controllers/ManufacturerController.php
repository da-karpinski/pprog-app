<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function list(){

        $manufacturers = Manufacturer::all();
        return response()->json($manufacturers);
    }

    public function select(string $id){

        if(intval($id)){
            $manufacturer = Manufacturer::find($id);
            if($manufacturer){
                return response()->json($manufacturer);
            }else{
                return response()->json(['status' => 'error', 'description' => 'manufacturer not found'], 404);
            }
        }else{
            return response()->json(['status' => 'error', 'description' => 'id must be an int value'], 404);
        }
    }

    public function add(Request $request){

        try{
            $result = Manufacturer::create($request->all());
        }catch (\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return response()->json($errorInfo);
        }
        return response()->json($result->toArray());
    }

    public function update(Request $request){

        $manufacturer = Manufacturer::find($request->get('id'));

        if($manufacturer){
            try{
                $manufacturer->update($request->all());
            }catch (\Illuminate\Database\QueryException $exception){
                $errorInfo = $exception->errorInfo;
                return response()->json($errorInfo);
            }
            return response()->json($manufacturer);
        }else{
            return response()->json(['status' => 'error', 'description' => 'manufacturer not found'], 404);
        }
    }

    public function delete(Request $request){

        if(intval($request->get('id'))){
            $manufacturer = Manufacturer::find($request->get('id'));
            if($manufacturer){
                $manufacturer->delete();
                return response()->json(['status' => 'success', 'description' => 'manufacturer deleted']);
            }else{
                return response()->json(['status' => 'error', 'description' => 'manufacturer not found'], 404);
            }
        }else{
            return response()->json(['status' => 'error', 'description' => 'id must be an int value'], 404);
        }
    }
}
