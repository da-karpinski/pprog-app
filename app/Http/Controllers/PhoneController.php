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

    public function export(){

        $fileName = 'exported-phones.csv';
        $phones = Phone::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Manufacturer', 'Model', 'Model (short)', 'Operating system','Screen size','Battery capacity',
                         'Rear cameras (qty)','Processor model','Processor cores & frequency','RAM size',
                         'Internal storage size','NFC','5G');

        $callback = function() use($phones, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($phones as $phone) {
                $row['manufacturer']   = $phone->manufacturer->name;
                $row['model']          = $phone->model;
                $row['model_short']    = $phone->model_short;
                $row['system']         = $phone->system->name . ' ' . $phone->system->version;
                $row['screen_size']    = $phone->screen_size;
                $row['battery']        = $phone->battery . ' mAh';
                $row['rear_cam_qty']   = $phone->rear_camera_quantity;
                $row['processor']      = $phone->processor->manufacturer . ' ' . $phone->processor->model;
                $row['processor_spec'] = $phone->processor->cores . 'x' . $phone->processor->max_frequency . ' GHz';
                $row['ram_size']       = $phone->ram_size;
                $row['storage_size']   = $phone->storage_size;

                if($phone->has_nfc) {
                    $hasNFC = 'YES';
                }else{
                    $hasNFC = 'NO';
                }
                $row['nfc'] = $hasNFC;

                if($phone->has_5g) {
                    $has5G = 'YES';
                }else{
                    $has5G = 'NO';
                }
                $row['5g'] = $has5G;

                fputcsv($file, array($row['manufacturer'], $row['model'], $row['model_short'], $row['system'],
                                     $row['screen_size'], $row['battery'], $row['rear_cam_qty'], $row['processor'],
                                     $row['processor_spec'], $row['ram_size'], $row['storage_size'], $row['nfc'], $row['5g']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(){

        $json = file_get_contents(storage_path('phone.json'));
        $json = json_decode($json,true);
        $response = []; $i = 0;

        foreach($json as $item){
            $i++;
            try{
                $result = Phone::create($item);
                $response[] = ['record_number' => $i, 'status'=> 'success'];
            }catch (\Illuminate\Database\QueryException $exception){
                $errorInfo = $exception->errorInfo;
                $response[] = ['record_number' => $i, 'status'=> 'failed', 'details' => $errorInfo];
            }

        }
        return response()->json($response);
    }
}
