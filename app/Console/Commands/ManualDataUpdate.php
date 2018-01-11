<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ManualDataUpdate extends Command
{
    protected $signature = 'domain:update';
    protected $description = 'Domain data file download';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $date = date("Y-m-d");
        $baseUrl3 ='http://s3.amazonaws.com/alexa-static/top-1m.csv.zip';
        $this->info('Downloading..');
        $path = './domains';
        file_put_contents($path . "/tmpfile.zip", file_get_contents($baseUrl3));
        $this->info('Extracting..');
        system("unzip -d $path $path/tmpfile.zip");
        $this->info('Renaming..');
        rename($path . "/top-1m.csv", $path . "/".$date.".csv" );
        $this->info('Deleting temporary files..');
        unlink($path . "/tmpfile.zip");
        $this->info('Success!');
    }
}

