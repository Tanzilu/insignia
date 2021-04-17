<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = 'payment';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_payment',
        'time',
        'price'
    ];

    public function parking()
    {
        return $this->belongsTo(Parking::class, 'no_payment', 'no_payment');
    }
}
