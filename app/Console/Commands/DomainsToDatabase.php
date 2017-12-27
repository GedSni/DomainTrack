<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Domain;

class DomainsToDatabase extends Command
{
    protected $signature = 'domain:add_domains';

    protected $description = 'Add domain data to database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $time_pre = microtime(true);
        $this->info('Defining variables..');
        //-------------------------------------------------
        //Variables
        //-------------------------------------------------
        $files = [];
        $data = [];
        $index = 0;
        $domains = $this->domainInput();
        if(!$domains){
            $this->warn('Command was concluded before taking action because user input was not correct');
            return null;
        }
        $log_directory = "./domains";
        //-------------------------------------------------
        //Loading files from domains directory
        //-------------------------------------------------
        $this->info('Loading data files..');
        foreach(glob($log_directory.'/*') as $file) {
            array_push($files, $file);
        }

        //-------------------------------------------------
        //Get data from .csv files
        //-------------------------------------------------
        $this->info('Loading data..');

        $file_handle = fopen($files[count($files)-1], 'r');
        for ($i = 0; $i < $domains; $i++) {
            $line = fgetcsv($file_handle);
            array_push($data, $line);
        }

        for ($i = 0; $i < $domains; $i++){
            //IDETI I DUOMENU BAZE
            //print_r($date. "  " . $data[$i][0]. " " . $data[$i][1]. "\n");
            Domain::updateOrCreate(['name'=>$data[$i][1]]);

            if($i % 1000 == 0){
                $index += 1000;
                $this->info($index. " done.");
            }
        }
        unset($data);
        fclose($file_handle);
        $this->warn("Memory usage: " . memory_get_usage(false) . " bytes of 134217728 allowed");
        //-------------------------------------------------
        //Stats
        //-------------------------------------------------
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        $this->info($exec_time. 's time spent overall');
        //-------------------------------------------------
        //Ending operations
        //-------------------------------------------------
        $this->info('Success!');
        //-------------------------------------------------
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
}
