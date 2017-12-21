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
        $this->info('Defining variables..');
        //-------------------------------------------------
        //Variables
        //-------------------------------------------------


        //all domains
        /*$data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.name as name, ranks.date as date, ranks.value as value, ranks.domain_id as domain_id'))
            ->orderBy('date', 'asc')
            //->groupBy('domain_id')
            ->get();*/

       //one domain
        $data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.name as name, ranks.date as date, ranks.value as value, ranks.domain_id as domain_id'))
            ->where('domains.name', '=', 'google.com')
            ->orderBy('date', 'asc')
            //->groupBy('domain_id')
            ->get();


        print_r($data);

        $this->info("Success!");

    }

    private function searchForDomainRank($domain, $rank_before, $array, $domains) {

        //Saraso pirmoje puseje
        if($rank_before < $domains / 2 || !isset($array[$domains-1]))
        {
            for($i = 0; $i < $domains; $i++){
                if ($array[$i][1] == $domain) {
                    return $array[$i][0];
                }
            }
        }
        //Saraso antroje puseje
        elseif($rank_before > $domains / 2 && isset($array[$domains-1]))
        {
            for($i = $domains-1; $i > 0; $i--){
                if ($array[$i][1] == $domain) {
                    return $array[$i][0];
                }
            }
        }

        $null_object = "---";
        return $null_object;
    }

    private function domainInput() {
        $domains = $this->ask('Number of domains to analyze (from the top): ');
        if(is_numeric($domains)){
            if($domains > "0"){
                return $domains;
            }
            else{
                $this->error("The number must positive");
                return null;
            }
        }
        else{
            $this->error("The value must be numeric");
            return null;
        }
    }

    private function printToConsole($output) {
        $mask = "|%-25.30s | %10s|%10s |%10s |\n";
        printf($mask,'Domain', 'Before', 'After', 'Shift');
        foreach($output as $line)
            printf($mask, $line[0], $line[1], $line[2], $line[3]);
    }

    private function printToCsv($output) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="domainList.csv"');

        $file = fopen("domainList.csv","a");

        foreach ($output as $line)
        {
            fputcsv($file, $line);
        }

        fclose($file);
    }

    private function prepareCsvFile($first_point, $last_point){

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="domainList.csv"');

        $whiteSpace = [];
        $header = array
        (
            "DOMAIN","RANK BEFORE","RANK AFTER","RANK SHIFT"
        );
        $interval = array
        (
            "Files used in analysis: ", $first_point, $last_point
        );

        $file = fopen("domainList.csv","w");

        fputcsv($file, $interval);
        fputcsv($file, $whiteSpace);
        fputcsv($file, $header);
        fputcsv($file, $whiteSpace);

        fclose($file);
    }

    private function formOutput($data, $data2, $domain_interval, $domains){
        $output = [];

        $time_in_pre = microtime(true);

        for($j = 0; $j < $domains; $j++){

            $temp_domain = $data[$j][1];
            $rank_before = $data[$j][0];
            $rank_after = $this->searchForDomainRank($temp_domain, $rank_before, $data2, $domains); // $domain_interval vietoje $domains

            if(is_numeric($rank_after) && is_numeric($rank_before)){
                $domain_rank_diff = $rank_before - $rank_after;
            }
            else{
                $domain_rank_diff = "---";
            }

            $output_object = [];
            array_push($output_object, $temp_domain, $rank_before, $rank_after, $domain_rank_diff);
            array_push($output, $output_object);

            unset($output_object);
        }

        $time_in_post = microtime(true);
        $exec_time = $time_in_post - $time_in_pre;
        $this->info($exec_time. "s time spent\n");

        return $output;
    }

    private function printData($print_mode, $output){
        if($print_mode == 'Console'){
            $this->printToConsole($output);
        }
        elseif($print_mode == 'CSV'){
            $this->printToCsv($output);
        }
        else{
            $this->error('Something went wrong with print mode choice');
        }
    }

}
