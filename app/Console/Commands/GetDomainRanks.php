<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        //Variables
        //-------------------------------------------------
        $files = [];
        $data = [];
        $data2 = [];
        $domain_rank_diffs = [];
        $domains = 100;
        $log_directory = "./domains";
        //-------------------------------------------------
        $this->info('Loading data files..');
        foreach(glob($log_directory.'/*') as $file) {
            array_push($files, $file);
        }

        $this->info('Setting analysis checkpoints..');
        $first_point = min($files);
        $last_point = max($files);

        //Get data from .csv to $data
        //-------------------------------------------------
        $this->info('Loading data..');

        $file = fopen($first_point, 'r');
        for ($i = 1; $i <= $domains; $i++) {
            $line = fgetcsv($file);
            array_push($data, $line);
        }
        fclose($file);
        $this->info('Fetched '.count($data).' domains from file '.$first_point);

        $file = fopen($last_point, 'r');
        for ($i = 1; $i <= $domains; $i++) {
            $line = fgetcsv($file);
            array_push($data2, $line);
        }
        fclose($file);
        $this->info('Fetched '.count($data2).' domains from file '.$last_point);
        //-------------------------------------------------

        $this->info('Processing..');

        $mask = "|%5.5s |%-25.30s | %10s|%10s |%10s |\n";
        printf($mask, '#', 'Domain', 'Before', 'After', 'Shift');

        for($i = 0; $i < $domains; $i++){
            $temp_domain = $data[$i][1];
            $rank_before = $data[$i][0];
            $rank_after = $this->searchForDomain($temp_domain, $data2, $domains);
            $domain_rank_diffs[$i][1] = $temp_domain;

            if(is_numeric($rank_after) && is_numeric($rank_before)){
                $domain_rank_diffs[$i][0] = $rank_after - $rank_before;
            }
            else{
                $domain_rank_diffs[$i][0] = "---";
            }

            printf($mask, $i, $temp_domain, $rank_before, $rank_after, $domain_rank_diffs[$i][0]);
        }

        $this->info('Success!');

        // $baseUrl = 'https://api.similarweb.com/v1/website/cnn.com/total-traffic-and-engagement/visits?api_key=a556e747082a435eb875bf79286432fd&start_date=2016-01&end_date=2016-03&main_domain_only=false&granularity=monthly';
        // $baseUrl2 ='https://www.similarweb.com/website/catfly.com';
        // $baseUrl3 ='http://s3.amazonaws.com/alexa-static/top-1m.csv.zip';
        // $baseUrl4 ='https://www.similarweb.com/website/';
        // $regexString = '#<span class=\"engagementInfo-valueNumber js-countValue\">[0-9]*\.?[0-9]+[a-zA-Z]#';
        // $regexString2 = "#[0-9]*\.?[0-9]+[a-zA-Z]#";
        // $scraped = "";

        //Getting page html into $html / GET request response to $response
        //$baseUrl4 .= $data[0][1];
        //-------------------------------------------------
        //$ch = curl_init();
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_URL, $baseUrl4);
        //$response = curl_exec($ch);
        //curl_close($ch);
        //$html = str_replace(["\r","\n"],"", $response);
        //-------------------------------------------------

     //Cannot get HTML because site detects bots (CANCELLED)
        //Getting traffic data to $traffic
        //-------------------------------------------------
        //preg_match_all($regexString, $html, $scraped);
        //$traffic = preg_grep($regexString2, $scraped);
        //-------------------------------------------------

        //Print out GET request response (HTML)
        //-------------------------------------------------
        //print_r($response);
        //-------------------------------------------------


        //Print out GET request response (JSON)
        //-------------------------------------------------
        //$obj = json_decode($response);
        //print_r($obj);
        //-------------------------------------------------
    }

    private function searchForDomain($id, $array, $domains) {
        for($i = 0; $i < $domains; $i++){
            if ($array[$i][1] == $id) {
                return $array[$i][0];
            }
        }
        $null_object = "---";
        return $null_object;
    }

}
