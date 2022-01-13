<?php

namespace App\Http\Controllers;

use App\Models\Processor;
use Illuminate\Http\Request;

class ProcessorController extends Controller
{
    public function list(){

        $processors = Processor::all();
        return response()->json($processors);
    }

    public function select(string $id){

        if(intval($id)){
            $processor = Processor::find($id);
            if($processor){
                return response()->json($processor);
            }else{
                return response()->json(['status' => 'error', 'description' => 'processor not found'], 404);
            }
        }else{
            return response()->json(['status' => 'error', 'description' => 'id must be an int value'], 404);
        }
    }

    public function add(Request $request){

        try{
            $result = Processor::create($request->all());
        }catch (\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return response()->json($errorInfo);
        }
        return response()->json($result->toArray());
    }

    public function update(Request $request){

        $processor = Processor::find($request->get('id'));

        if($processor){
            try{
                $processor->update($request->all());
            }catch (\Illuminate\Database\QueryException $exception){
                $errorInfo = $exception->errorInfo;
                return response()->json($errorInfo);
            }
            return response()->json($processor);
        }else{
            return response()->json(['status' => 'error', 'description' => 'processor not found'], 404);
        }
    }

    public function delete(Request $request){

        if(intval($request->get('id'))){
            $processor = Processor::find($request->get('id'));
            if($processor){
                $processor->delete();
                return response()->json(['status' => 'success', 'description' => 'processor deleted']);
            }else{
                return response()->json(['status' => 'error', 'description' => 'processor not found'], 404);
            }
        }else{
            return response()->json(['status' => 'error', 'description' => 'id must be an int value'], 404);
        }
    }
}
