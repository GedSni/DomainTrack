<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Domain;
use App\Rank;

class DataUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:dat {domains?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Domain data new daily update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Defining variables');
        $timePre = microtime(true);
        $domains = $this->argument('domains');
        if (!isset($domains)) {
            $domains = 100000;
        } else {
            $this->info("Domains variable was taken from command arguments");
        }
        $baseUrl3 ='http://s3.amazonaws.com/alexa-static/top-1m.csv.zip';
        $this->info('Downloading..');
        $path = storage_path();
        file_put_contents($path . "/tmpfile.zip", file_get_contents($baseUrl3));
        $this->info('Extracting..');
        system("unzip -d $path $path/tmpfile.zip");
        $this->info('Deleting temporary files..');
        unlink($path . '/tmpfile.zip');
        $this->info('Processing..');
        $fileHandle = fopen("$path/top-1m.csv", 'r');
        $fileDate = date("Y-m-d");
        DB::beginTransaction();
        for ($i = 0; $i < $domains; $i++) {
            echo "( " . $i . " / " . $domains . " )\r";
            $line = fgetcsv($fileHandle);
            $domain = Domain::firstOrCreate(
                [
                    'name' => $line[1]
                ]
            );
            Rank::firstOrCreate(
                [
                    'domain_id' => $domain->id,
                    'date' => $fileDate,
                    'rank' => $line[0]
                ]
            );
        }
        DB::commit();
        fclose($fileHandle);
        unlink("$path/top-1m.csv");
        //$this->call('domain:stat');
        $this->info('Processing ended..');
        $timePost = microtime(true);
        $execTime = $timePost - $timePre;
        $this->info(round($execTime). 's spent overall');
        $this->info('Success!');
    }
}