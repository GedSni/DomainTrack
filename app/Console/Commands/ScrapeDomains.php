<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapeDomains extends Command
{
    protected $signature = 'get:domains';

    protected $description = 'Get the traffic history of domains';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting variable initialization');
        //Variables
        //-------------------------------------------------
        $data = [];
        $date = date("Y-m-d H-i-s");
        $domains = 50000;
        $baseUrl = 'https://api.similarweb.com/v1/website/cnn.com/total-traffic-and-engagement/visits?api_key=a556e747082a435eb875bf79286432fd&start_date=2016-01&end_date=2016-03&main_domain_only=false&granularity=monthly';
        $baseUrl2 ='https://www.similarweb.com/website/catfly.com';
        $baseUrl3 ='http://s3.amazonaws.com/alexa-static/top-1m.csv.zip';
        $baseUrl4 ='https://www.similarweb.com/website/';
        $regexString = '#<span class=\"engagementInfo-valueNumber js-countValue\">[0-9]*\.?[0-9]+[a-zA-Z]#';
        $regexString2 = "#[0-9]*\.?[0-9]+[a-zA-Z]#";
        $scraped = "";
        //-------------------------------------------------
        $this->info('Starting to download the file');
        file_put_contents("Tmpfile.zip", file_get_contents($baseUrl3));

        $this->info('Starting extracting the file');
        system('unzip Tmpfile.zip');

        $this->info('Renaming the file');
        rename("./top-1m.csv", "./domains ".$date.".csv" );

        //Get data from .csv to $data
        //-------------------------------------------------
        $this->info('Getting domains data from file');
        $file = fopen("./domains ".$date.".csv", 'r');
        for ($i = 1; $i <= $domains; $i++) {
            $line = fgetcsv($file);
            array_push($data, $line);
        }
        fclose($file);
        $this->info('Fetched '.count($data).' domains');
        //-------------------------------------------------

        $baseUrl4 .= $data[0][1];

        //Getting page html into $html / GET request response to $response
        //-------------------------------------------------
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $baseUrl4);
        $response = curl_exec($ch);
        curl_close($ch);
        //$html = str_replace(["\r","\n"],"", $response);
        //-------------------------------------------------

     //Cannot get HTML because site detects bots
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
}
