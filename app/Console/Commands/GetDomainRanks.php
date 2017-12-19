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
        //-------------------------------------------------
        //Variables
        //-------------------------------------------------
        $files = [];
        $data = [];
        $data2 = [];
        $update = $this->choice('Update today\'s data before proceeding?: ', ['No', 'Yes']);
        $print_mode = $this->choice('Print results to: ', ['Console', 'CSV']);
        if($update == "Yes"){
            $this->call('domain:update');
        }
        $domains = $this->domainInput();
        if(!$domains){
            $this->warn('Command was concluded before taking action because user input was not correct');
            return null;
        }
        $domains_left = $domains;
        $domain_interval = 25000;
        $log_directory = "./domains";
        //-------------------------------------------------
        //Loading files from domains directory
        //-------------------------------------------------
        $this->info('Loading data files..');
        foreach(glob($log_directory.'/*') as $file) {
            array_push($files, $file);
        }

        $this->info('Setting analysis checkpoints..');
        $first_point = min($files);
        $last_point = max($files);
        //-------------------------------------------------
        //Get data from .csv to $data
        //-------------------------------------------------
        $this->info('Loading data..');

        $file1 = fopen($first_point, 'r');
        $file2 = fopen($last_point, 'r');

        $this->prepareCsvFile($first_point, $last_point);

        for ($i = 1; $i <= $domains; $i++) {
            $line2 = fgetcsv($file2);
            array_push($data2, $line2);
        }
        $time_pre = microtime(true);
        $this->info("Processing (might take a while)..\n");
        for ($i = 1; $i <= $domains; $i++) {
            $time_in_pre = microtime(true);
            $line1 = fgetcsv($file1);
            array_push($data, $line1);

            if($i % $domain_interval == 0 && $domains_left > $domain_interval){
                $domains_left -= $domain_interval;
                $output = $this->formOutput($data, $data2, $domain_interval, $domains);
                $this->printData($print_mode, $output);


                $this->info($domains_left. ' domains left to process');
                $this->warn("Memory usage: " . memory_get_usage(false) . " bytes of 134217728 allowed");
                $time_in_post = microtime(true);
                $exec_time = $time_in_post - $time_in_pre;
                $this->info($exec_time. "s time spent\n");

                unset($output);
                unset($data);
                $data = [];
            }
        }
        //-------------------------------------------------
        //Last data
        //-------------------------------------------------
        $output = $this->formOutput($data, $data2, $domains_left, $domains);
        $this->printData($print_mode, $output);
        //-------------------------------------------------
        //Stats
        //-------------------------------------------------
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        $this->info($exec_time. 's time spent overall');
        //-------------------------------------------------
        //Closing files and unsetting variables to free memory
        //-------------------------------------------------
        unset($output);
        unset($data);
        unset($data2);
        fclose($file1);
        fclose($file2);
        //-------------------------------------------------
        //Ending operations
        //-------------------------------------------------
        $this->info('Success!');
        //-------------------------------------------------


//******************************************************************************************************
        //Cannot get HTML because site detects bots (CANCELLED)
//******************************************************************************************************
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

        for($j = 0; $j < $domain_interval; $j++){
            $temp_domain = $data[$j][1];
            $rank_before = $data[$j][0];
            $rank_after = $this->searchForDomain($temp_domain, $data2, $domains);

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
