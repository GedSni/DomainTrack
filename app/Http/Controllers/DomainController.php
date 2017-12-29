<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    public function index()
    {
        $timePeriod = request()->get('timePeriod');

        switch($timePeriod) {
            case "Day":
                $data = DB::table('domains')
                    ->select(DB::raw('id, name, day_rank, day_diff'))
                    ->orderBy('day_diff', 'desc')
                    ->get();
                break;
            case "Week":
                $data = DB::table('domains')
                    ->select(DB::raw('id, name, week_rank, week_diff'))
                    ->orderBy('week_diff', 'desc')
                    ->get();
                break;
            case "Month":
                $data = DB::table('domains')
                    ->select(DB::raw('id, name, month_rank, month_diff'))
                    ->orderBy('month_diff', 'desc')
                    ->get();
                break;
            default:
                $data = DB::table('domains')
                    ->select(DB::raw('id, name, day_rank, day_diff'))
                    ->orderBy('day_diff', 'desc')
                    ->get();
                break;
        }

        return view('home')
            ->with('data', $data)
            ->with('timePeriod', $timePeriod);
    }

}
