<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'invoice',
        'email',
        'payment_status',
        'fullfilment_status',
        'total'
    ];
}
