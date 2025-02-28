<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{

    protected $fillable = ['name'];

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
