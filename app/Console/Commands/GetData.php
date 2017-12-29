<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        $this->info('Defining variables');
        $time_pre = microtime(true);
        $date = date("Y-m-d");
        $files = [];
        $day = date('D');
        $month = date('d');
        $domains = $this->argument('domains');
        if (!isset($domains)) {
            $domains = 100000;
        } else {
            $this->info("Domains variable was taken from command arguments");
        }
        $url = 'http://s3.amazonaws.com/alexa-static/top-1m.csv.zip';
        $log_directory = "./domains";

        $this->info('Downloading..');
        file_put_contents("./domains/Tmpfile.zip", file_get_contents($url));

        $this->info('Extracting..');
        system('unzip -d ./domains  ./domains/Tmpfile.zip');

        $this->info('Renaming..');
        rename("./domains/top-1m.csv", "./domains/".$date.".csv" );

        $this->info('Deleting temporary files..');
        unlink('./domains/Tmpfile.zip');

        $this->info('Loading data files..');
        foreach (glob($log_directory . '/*') as $file) {
            array_push($files, $file);
        }
        $this->info('Processing..');
        $file_handle = fopen($files[count($files)-1], 'r');
        for ($i = 0; $i < $domains; $i++) {
            echo "( " . $i . " / " . $domains . " )\r";
            $line = fgetcsv($file_handle);
            $newDayRank = $line[0];
            $oldDomain = DB::table('domains')
                ->select('id', 'name', 'day_rank', 'week_rank', 'month_rank')
                ->where('domains.name', '=', $line[1])
                ->get();
            if (!isset($oldDomain[0])) {
                Domain::updateOrCreate(
                    [
                        'name' => $line[1]
                    ]
                );
                $oldDomain = DB::table('domains')
                    ->select('id', 'name', 'day_rank', 'week_rank', 'month_rank')
                    ->where('domains.name', '=', $line[1])
                    ->get();
            }
            $newDayDiff = $oldDomain[0]->day_rank - $newDayRank;
            Domain::updateOrCreate(
                [
                    'name' => $oldDomain[0]->name,
                    'id' => $oldDomain[0]->id,

                ],
                [
                    'day_rank' => $newDayRank,
                    'day_diff' => $newDayDiff,
                    'day_update_date' => $date
                ]
            );
            if ($day == 'Mon') {
                $newWeekRank = $line[0];
                $newWeekDiff = $oldDomain[0]->week_rank - $newWeekRank;
                Domain::updateOrCreate(
                    [
                        'name' => $oldDomain[0]->name,
                        'id' => $oldDomain[0]->id
                    ],
                    [
                        'week_rank' => $newWeekRank,
                        'week_diff' => $newWeekDiff,
                        'week_update_date' => $date
                    ]
                );
            }
            if ($month == 01) {
                $newMonthRank = $line[0];
                $newMonthDiff = $oldDomain[0]->month_rank - $newMonthRank;
                Domain::updateOrCreate(
                    [
                        'name' => $oldDomain[0]->name,
                        'id' => $oldDomain[0]->id
                    ],
                    [
                        'month_rank' => $newMonthRank,
                        'month_diff' => $newMonthDiff,
                        'month_update_date' => $date
                    ]
                );
            }
        }

        DB::table('domains')->where('day_update_date', '<>', $date)->delete();
        $this->info('Processing ended..');
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        $this->info(round($exec_time). 's spent overall');
        $this->info('Success!');
    }
}
//https://www.youtube.com/watch?v=lYUowWrlyyw&list=UUPzWlhG7QM56Y8MYB3qMVnQ&index=1
