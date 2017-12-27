<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Rank;

class RanksToDatabase extends Command
{
    protected $signature = 'domain:add_ranks {domains?}';

    protected $description = 'Add ranks from all files to database';

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
        $domains = $this->argument('domains');
        if (!isset($domains)) {
            $domains = $this->domainInput();
            if (!$domains) {
                $this->warn('Command was concluded before taking action because user input was not correct');
                return null;
            }
        }
        else{
            $this->info("Domains variable was taken from command arguments");
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
        for($j = 0; $j < count($files); $j++) {
            $this->info('Files done:'. $j."/".count($files)."\n");
            $file_handle = fopen($files[$j], 'r');
            $date = new DateTime(substr($files[$j], -14, 10));
            for ($i = 0; $i < $domains; $i++) {
                $line = fgetcsv($file_handle);
                array_push($data, $line);
            }

            $domain_data = DB::table('domains')
                ->select(DB::raw('domains.id as id, domains.name as name'))
                ->orderBy('id', 'asc')
                ->get();

            for ($i = 0; $i < count($domain_data); $i++){
                $success = false;
                for ($k = 0; $k < $domains; $k++) {
                    if( $domain_data[$i]->name == $data[$k][1]) {
                        Rank::updateOrCreate(
                            [
                                'date'=>$date,
                                'value' => $data[$k][0],
                                'domain_id' => $domain_data[$i]->id
                            ]);

                        $success = true;
                        break;
                    }
                }
                if(!$success){
                    Rank::updateOrCreate(
                        [
                            'date'=>$date,
                            'value' => 'N/A',
                            'domain_id' => $domain_data[$i]->id
                        ]);
                }
            }
            unset($data);
            $data = [];
            fclose($file_handle);
            $this->warn("Memory usage: " . memory_get_usage(false) . " bytes of 134217728 allowed");
        }

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