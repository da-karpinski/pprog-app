<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Processor extends Model
{

    protected $fillable = [
      'manufacturer','model','cores','max_frequency'
    ];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
