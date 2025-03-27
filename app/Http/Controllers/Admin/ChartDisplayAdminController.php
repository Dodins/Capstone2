<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartDisplayAdminController extends Controller
{
    public function showDailyReports()
    {
        // Fetch the first report date
        $firstReportDate = Concern::orderBy('created_at', 'asc')->value('created_at');

        if (!$firstReportDate) {
            return response()->json([]);
        }

        $firstReportDate = Carbon::parse($firstReportDate)->startOfDay();
        $currentDate = Carbon::now()->startOfDay();

        // Generate a list of all dates from the first report date to the current date
        $allDates = [];
        for ($date = $firstReportDate; $date->lte($currentDate); $date->addDay()) {
            $allDates[$date->format('Y-m-d')] = 0;
        }

        // Fetch the report counts for each date
        $dailyReports = Concern::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Combine the dates and counts to ensure all dates are included
        foreach ($dailyReports as $date => $count) {
            $allDates[$date] = $count;
        }

        // Format the data for the response
        $formattedReports = [];
        foreach ($allDates as $date => $count) {
            $formattedReports[] = [
                'date' => $date,
                'count' => $count,
            ];
        }

        return response()->json($formattedReports);
    }
}
