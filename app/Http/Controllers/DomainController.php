<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use DateTime;

class DomainController extends Controller
{
    public function index()
    {

        $dataDay = DB::table('domains')
            ->select(DB::raw('id, name, day_rank, day_diff, day_update_date'))
            ->orderBy('day_diff', 'desc')
            ->take(20)
            ->get();
        $dataWeek = DB::table('domains')
            ->select(DB::raw('id, name, week_rank, week_diff, week_update_date'))
            ->orderBy('week_diff', 'desc')
            ->take(20)
            ->get();
        $dataMonth = DB::table('domains')
            ->select(DB::raw('id, name, month_rank, month_diff, month_update_date'))
            ->orderBy('month_diff', 'desc')
            ->take(20)
            ->get();
        return view('home')
            ->with('dataDay', $dataDay)
            ->with('dataWeek', $dataWeek)
            ->with('dataMonth', $dataMonth);
    }
}
