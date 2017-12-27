<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetDomainRanks extends Command
{
    protected $signature = 'domain:ranks';

    protected $description = 'Domain rank differences from available data';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
       // $this->info('Defining variables..');
        //-------------------------------------------------
        //Variables
        //-------------------------------------------------


        //all domains and ranks
        /*$data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.name as name, ranks.date as date, ranks.value as value, ranks.domain_id as domain_id'))
            ->orderBy('date', 'asc')
            ->get();*/

       //one domain
       /* $data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.name as name, ranks.date as date, ranks.value as value, ranks.domain_id as domain_id'))
            ->where('domains.name', '=', 'google.com')
            ->orderBy('date', 'asc')
            ->get();*/

       //all domain's ranks
        /*$data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('ranks.date as date, ranks.value as value'))
            ->where('domains.name', '=', 'google.com')
            ->orderBy('date', 'asc')
            ->get();*/

        //all domains
        /*$data = DB::table('domains')
            ->select(DB::raw('domains.id as id, domains.name as name'))
            ->orderBy('id', 'asc')
            ->get();*/

       //all ranks
        /*$data2 = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.name as name, ranks.date as date, ranks.value as value, ranks.domain_id as domain_id'))
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();*/

        //all dates
       /* $data2 = DB::table('ranks')
            ->select(DB::raw('ranks.date as date'))
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->get();*/

       // print_r($data);
       // print_r($data2);

       // $this->info("Success!");

    }
}
