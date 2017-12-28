<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Rank;
use App\Domain;

class GetData extends Command
{
    protected $signature = 'domain:data {domains?}';
    protected $description = 'Data to database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //-------------------------------------------------
        //Variables
        //-------------------------------------------------
        $this->info('Defining variables');
        $time_pre = microtime(true);
        $date = date("Y-m-d");
        $files = [];
        $data = [];
        $domains = $this->argument('domains');
        if (!isset($domains)) {
            $domains = 100000;
        } else {
            $this->info("Domains variable was taken from command arguments");
        }
        $index = 0;
        $url ='http://s3.amazonaws.com/alexa-static/top-1m.csv.zip';
        $log_directory = "./domains";
        //-------------------------------------------------
        //Loading files from domains directory
        //-------------------------------------------------
        $this->info('Loading data files..');
        foreach (glob($log_directory.'/*') as $file) {
            array_push($files, $file);
        }

        //-------------------------------------------------
        //Downloading/processing
        //-------------------------------------------------
        $this->info('Downloading..');
        file_put_contents("./domains/Tmpfile.zip", file_get_contents($url));

        $this->info('Extracting..');
        system('unzip -d ./domains  ./domains/Tmpfile.zip');

        $this->info('Renaming..');
        rename("./domains/top-1m.csv", "./domains/".$date.".csv" );

        $this->info('Deleting temporary files..');
        unlink('./domains/Tmpfile.zip');
        //-------------------------------------------------
        //Adding domains data to database
        //-------------------------------------------------
        $this->info('Adding domains data to database..');
        $file_handle = fopen($files[count($files)-1], 'r');
        for ($i = 0; $i < $domains; $i++) {
            $line = fgetcsv($file_handle);
            array_push($data, $line);
        }

        for ($i = 0; $i < $domains; $i++){
            Domain::updateOrCreate(['name'=>$data[$i][1]]);
            if ($i % 1000 == 0){
                $index += 1000;
                $this->info($index. " done.");
            }
        }
        unset($data);
        $data = [];
        fclose($file_handle);
        $this->warn("Memory usage: " . memory_get_usage(false) . " bytes of 134217728 allowed");
        //-------------------------------------------------
        //Adding ranks data to database
        //-------------------------------------------------
        $this->info('Adding ranks data to database..');


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
                            'value' => null,
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
        $domains = $this->ask('Number of domains to analyze (100k by default): ');
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
            $this->info("Assigning the default value of 100k");
            return 100000;
        }
    }
}
