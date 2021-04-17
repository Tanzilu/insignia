<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function getPaymentbyNoPayment($noPayment)
    {
        $payment = Payment::where('no_payment', '=', $noPayment)->first();
        $payment->parking;
        return response()->json(['payment' => $payment], 200);
    }
}
