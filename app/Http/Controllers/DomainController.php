<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Domain;

class DomainController extends Controller
{

    //Needs pagination
    public function index()
    {

        $domain_data = DB::table('domains')
            ->select(DB::raw('domains.id as id, domains.name as name'))
            ->orderBy('id', 'asc')
            ->get();

        $rank_data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.name as name, ranks.date as date, ranks.value as value, ranks.domain_id as domain_id'))
            ->orderBy('date', 'asc')
            ->get();

        $date_data = DB::table('ranks')
            ->select(DB::raw('ranks.date as date'))
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();

        $earliest_date = $date_data[0];
        $latest_date = $date_data[count($date_data)-1];

        $shift_data = [];

        for($i = 0; $i < count($domain_data); $i++){
            for($j = 0; $j < count($rank_data); $j++) {
                if($rank_data[$j]->domain_id == $domain_data[$i]->id){
                    if($rank_data[$j]->date == $earliest_date->date){
                        $earliest_rank = $rank_data[$j]->value;
                    }
                    if($rank_data[$j]->date == $latest_date->date){
                        $latest_rank = $rank_data[$j]->value;
                    }
                }
            }

            if($earliest_rank == "N/A")
            {
                $shift = "N/A";
            }
            else{
                $shift = $latest_rank - $earliest_rank;
            }
            $single_shift = [
                $domain_data[$i]->id => $shift,
            ];
            array_push($shift_data, $single_shift);
        }



        return view('home')
            ->with('domain_data', $domain_data)
            ->with('rank_data', $rank_data)
            ->with('date_data', $date_data)
            ->with('shift_data', $shift_data);
    }

    public function show($id)
    {
        $domain = Domain::findOrFail($id);

        $date_data = DB::table('ranks')
            ->select(DB::raw('ranks.date as date'))
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();

        $ranks = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('ranks.date as date, ranks.value as value, ranks.domain_id as domain_id'))
            ->where('domains.name', '=', $domain->name)
            ->orderBy('date', 'asc')
            ->get();

        $earliest_date = $date_data[0];
        $latest_date = $date_data[count($date_data)-1];

        for($j = 0; $j < count($ranks); $j++) {
            if($ranks[$j]->domain_id == $domain->id){
                if($ranks[$j]->date == $earliest_date->date){
                    $earliest_rank = $ranks[$j]->value;
                }
                if($ranks[$j]->date == $latest_date->date){
                    $latest_rank = $ranks[$j]->value;
                }
            }
        }

        if($earliest_rank == "N/A")
        {
            $shift = "N/A";
        }
        else{
            $shift = $latest_rank - $earliest_rank;
        }

        return view('singleDomain')
            ->with('domain', $domain)
            ->with('date_data', $date_data)
            ->with('ranks', $ranks)
            ->with('shift', $shift);
    }
}
