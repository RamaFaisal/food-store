<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $fillable = [
        'name', 'provience_id'
    ];

    public function provience()
    {
        return $this->belongsTo(Provience::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
