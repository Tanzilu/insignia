<?php

namespace App\Http\Controllers;

use App\Parking;
use App\Payment;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParkingController extends Controller
{
    public function enterParking(Request $request)
    {
        try {

            // $request->validate([
            //     'license_plate' => [
            //         'required',
            //         'regex:/^[A-Z]{1,2}-[0-9]{1,4}-[A-Z]{1,3}$/i'
            //     ]
            // ]);

            $checkAlreadyParking = Parking::where('license_plate', '=', $request->license_plate)
                ->whereNull('out')->exists();
            if ($checkAlreadyParking) {
                $status = "Kendaraan masih terparkir";
                return response()->json(['status' => $status], 422);
            }

            DB::beginTransaction();

            $currentTime = Carbon::now()->timezone('Asia/Jakarta');
            $parking = new Parking;
            $parking->no_payment = $parking->generateNoPayment();
            $parking->license_plate = $request->license_plate;
            $parking->in = $currentTime->toDateTimeString();

            $payment = new Payment;
            $payment->no_payment = $parking->no_payment;

            $payment->save();
            $parking->save();


            DB::commit();
            $status = "Berhasil parkir";
            return response()->json(['status' => $status, 'invoice' => $parking, 'IsParking' => true], 200);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function exitParking(Request $request)
    {
        try {
            DB::beginTransaction();

            $checkAlreadyExit = Parking::where('no_payment', '=', $request->no_payment)
                ->whereNotNull('out')->exists();

            if ($checkAlreadyExit) {
                $status = "Kendaraan sudah keluar";
                return response()->json(['status' => $status], 422);
            }

            $currentTime = Carbon::now()->timezone('Asia/Jakarta');
            $parking = Parking::where('no_payment', '=', $request->no_payment)->first();
            $parking->out = $currentTime->toDateTimeString();

            $outDateTime = date_create($parking->out);

            $inDateTime = date_create($parking->in);

            $diff = date_diff($inDateTime, $outDateTime);

            // $timePrice = Carbon::createFromTimestamp('16164638491', 'Asia/Jakarta')->toDateTimeString();

            $timePrice = $diff->format('%H');

            $payment = Payment::where('no_payment', '=', $request->no_payment)->first();
            if ($timePrice <= 0) {
                $payment->price = 3000;
            } else {

                $payment->price = $timePrice * 3000;
            }
            $payment->time = $diff->format('%H:%i:%s');

            $payment->save();
            $parking->save();

            $data = $parking->payment;

            DB::commit();
            $status = "Pembayaran telah berhasil";
            return response()->json(['status' => $status, 'invoice' => $data, 'isAlreadyPay' => true], 200);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
