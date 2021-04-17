<?php

namespace App\Http\Controllers;

use App\Parking;
use DateTime;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getDataReport(Request $request)
    {
        $report = Parking::with([
            'payment'
        ])
            ->whereNotNull('out')
            ->get();

        return response()->json($report, 200);
    }

    public function getDataReportWithFilter(Request $request)
    {
        $report = Parking::with([
            'payment'
        ])
            ->whereNotNull('out')
            ->whereBetween('out', [$request->date_start, $request->date_finish])
            ->get();

        return response()->json($report, 200);
    }

    public function getDataReportActive(Request $request)
    {
        $report = Parking::whereNull('out')
            ->get();

        return response()->json($report, 200);
    }
}
