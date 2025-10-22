<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'customer_id',
        'shipping_id',
        'provience_id',
        'city_id',
        'district_id',
        'invoice',
        'weight',
        'address',
        'total',
        'status',
        'snap_token'
    ];

    public function TransactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function provience()
    {
        return $this->belongsTo(Provience::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);   
    }
}
