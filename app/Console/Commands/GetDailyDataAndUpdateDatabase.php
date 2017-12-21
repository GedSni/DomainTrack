<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain;

class GetDailyDataAndUpdateDatabase extends Command
{
    protected $signature = 'domain:update_db';

    protected $description = 'Domain rank data download of current day and update database';


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
        $date = date("Y-m-d");
        $baseUrl3 ='http://s3.amazonaws.com/alexa-static/top-1m.csv.zip';
        //-------------------------------------------------
        //Operations
        //-------------------------------------------------
        $this->info('Downloading..');
        file_put_contents("./domains/Tmpfile.zip", file_get_contents($baseUrl3));

        $this->info('Extracting..');
        system('unzip -d ./domains  ./domains/Tmpfile.zip');

        $this->info('Renaming..');
        rename("./domains/top-1m.csv", "./domains/".$date.".csv" );

        $this->info('Deleting temporary files..');
        unlink('./domains/Tmpfile.zip');

        $domains = Domain::count();

        $this->call('domain:add_ranks', [
            'domains' => $domains
        ]);

        $this->info('Success!');
        //-------------------------------------------------

    }
}
