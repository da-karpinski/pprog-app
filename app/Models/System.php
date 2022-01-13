<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{

     protected $fillable = [
        'name','version'
     ];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
