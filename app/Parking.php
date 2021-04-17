<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Parking extends Model
{
    protected $table = 'parking';
    protected $primaryKey = 'id';
    protected $fillable = [
        'license_plate',
        'no_payment',
        'in',
        'out'
    ];

    protected $validations = [
        'license_plate' => 'required',
        'in' => 'datetime',
        'out' => 'datetime'
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'no_payment', 'no_payment');
    }

    public function generateNoPayment()
    {
        return Str::random(10);
    }
}
