<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getDataPerDay()
    {
        $data = Payment::selectRaw('count(id) as sum, day(updated_at) day')
            ->whereNotNull('price')
            ->groupBy('day')
            ->get();
        return response()->json($data, 200);
    }

    public function getDataPerMonth()
    {
        $data = Payment::selectRaw('count(id) as sum, monthname(updated_at) month')
            ->whereNotNull('price')
            ->groupBy('month')
            ->get();
        return response()->json($data, 200);
    }

    public function getDataPerYear()
    {
        $data = Payment::selectRaw('count(id) as sum, year(updated_at) year')
            ->whereNotNull('price')
            ->groupBy('year')
            ->get();
        return response()->json($data, 200);
    }
}
