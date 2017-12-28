<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    public function index()
    {

        $today = date("Y-m-d");
        $date = request()->get('date');

        if ($date == null) {
            //Pirmasis failas
            $date = '2017-12-14';
        }

        //Vaizduojant gaunama taip, kad saraso gale yra domain'ai, kurie pries tai nebuvo sarase. Visi domain'ai, kurie
        //nebuvo sarase sortinasi pagal tai, kiek daug jie pakilo. Pvz, jei saraso riba yra 1000, tai domain'as is uz
        //saraso ribos pakiles i 999 vieta bus zemiau uz ta domain'a, kuris is uz saraso ribos pakilo i 900 vieta.
        //Pirmasis domain'as tures reiksme -999, kai antrasis domainas tures reiksme -900.
        $data = DB::select("select domains.id, domains.name, r1.domain_id, r1.value as value_after, r2.value as value_before
                                from domains, ranks r1
                                left join ranks r2
                                on r2.date = '$date'
                                where r1.date = '2017-12-28' and r1.domain_id = r2.domain_id and r1.domain_id = domains.id
                                order by r1.value - IFNULL(r2.value, 0)");

        $date_data = DB::table('ranks')
            ->select(DB::raw('ranks.date as date'))
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();

        return view('home')
            ->with('data', $data)
            ->with('date', $date)
            ->with('today', $today)
            ->with('date_data', $date_data);
    }

}
