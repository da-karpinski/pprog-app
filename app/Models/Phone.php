<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    protected $fillable = [
        'manufacturer_id','model','model_short','system_id','screen_size','battery','rear_camera_quantity',
        'processor_id','ram_size','storage_size','has_nfc','has_5g'
    ];

    public function processor()
    {
        return $this->belongsTo(Processor::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }


}
