<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    public function index()
    {
        $yesterday = date("Y-m-d", strtotime("yesterday"));
        $lastMonday = date("Y-m-d", strtotime("last monday"));
        $firstMonthDay =  date("Y-m-d", strtotime("first day of this month"));
        $data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.id, domains.name, domains.status, ranks.rank, ranks.date'))
            ->whereRaw('ranks.date = (select MAX(ranks.date) from ranks)')
            ->orderBy('ranks.rank', 'asc')
            ->take(250)
            ->get();
        dd($data);
        $dataDay = $this->getData($yesterday);
        $dataWeek = $this->getData($lastMonday);
        $dataMonth = $this->getData($firstMonthDay);
        $dataDay = $this->getDiff($dataDay, $data);
        $dataWeek = $this->getDiff($dataWeek, $data);
        $dataMonth = $this->getDiff($dataMonth, $data);
        $dataDay = $dataDay->sortByDesc('diff');
        $dataWeek = $dataWeek->sortByDesc('diff');
        $dataMonth = $dataMonth->sortByDesc('diff');
        return view('home')
            ->with('dataDay', $dataDay)
            ->with('dataWeek', $dataWeek)
            ->with('dataMonth', $dataMonth);
    }

    private function getData($time)
    {
        $data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.id, domains.name, domains.status, ranks.rank, ranks.date'))
            ->where('ranks.date', '=', $time)
            ->orderBy('ranks.rank', 'asc')
            ->take(250)
            ->get();
        return $data;
    }

    private function getDiff($intervalData, $data)
    {
        for ($i = 0; $i < count($intervalData); $i++) {
            for ($j = 0; $j < count($data); $j++) {
                if ($intervalData[$i]->name == $data[$j]->name) {
                    $intervalData[$i]->diff = $data[$i]->rank - $intervalData[$j]->rank;
                }
            }
        }
        return $intervalData;
    }

}

