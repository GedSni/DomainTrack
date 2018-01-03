<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Domain;
use App\Rank;
use DateTime;

class DailyDataUpdate extends Command
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
        $files = [];
        $day = date('D');
        $month = date('d');
        $log_directory = "./domains";
        $domains = $this->argument('domains');
        if (!isset($domains)) {
            $domains = 100000;
        } else {
            $this->info("Domains variable was taken from command arguments");
        }
        //$this->call('domain:update');
        $this->info('Loading data files..');
        foreach (glob($log_directory . '/*') as $file) {
            array_push($files, $file);
        }
        $this->info('Processing..');
        $fileHandle = fopen($files[count($files)-1], 'r');
        $fileDate = new DateTime(substr($files[count($files)-1], -14, 10));
        for ($i = 0; $i < $domains; $i++) {
            echo "( " . $i . " / " . $domains . " )\r";
            $line = fgetcsv($fileHandle);
            $newDayRank = $line[0];
            $oldDomain = DB::table('domains')
                ->select('id', 'name', 'day_rank', 'week_rank', 'month_rank', 'day_update_date', 'week_update_date',
                    'month_update_date')
                ->where('domains.name', '=', $line[1])
                ->get();
            if (!isset($oldDomain[0])) {
                Domain::updateOrCreate(
                    [
                        'name' => $line[1]
                    ]
                );
                $oldDomain = DB::table('domains')
                    ->select('id', 'name', 'day_rank', 'week_rank', 'month_rank', 'day_update_date', 'week_update_date',
                        'month_update_date')
                    ->where('domains.name', '=', $line[1])
                    ->get();
            }
            if ($fileDate->format('Y-m-d') != $oldDomain[0]->day_update_date) {
                $newDayDiff = $oldDomain[0]->day_rank - $newDayRank;
                Domain::updateOrCreate(
                    [
                        'name' => $oldDomain[0]->name,
                        'id' => $oldDomain[0]->id,

                    ],
                    [
                        'day_rank' => $newDayRank,
                        'day_diff' => $newDayDiff,
                        'day_update_date' => $fileDate
                    ]
                );
            }
            if ($day == 'Thu' && $fileDate->format('Y-m-d') != $oldDomain[0]->week_update_date) {
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
                        'week_update_date' => $fileDate
                    ]
                );
            }
            if ($month == 14 && $fileDate->format('Y-m-d') != $oldDomain[0]->month_update_date) {
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
                        'month_update_date' => $fileDate
                    ]
                );
                Rank::updateOrCreate(
                    [
                        'date' => $fileDate,
                        'domain_id' => $oldDomain[0]->id,
                        'value' => $newMonthRank
                    ]
                );
            }
        }
        fclose($fileHandle);
        $this->info('Processing ended..');
        $time_post = microtime(true);
        $exec_time = $time_post - $time_pre;
        $this->info(round($exec_time). 's spent overall');
        $this->info('Success!');
    }
}
//https://www.youtube.com/watch?v=lYUowWrlyyw&list=UUPzWlhG7QM56Y8MYB3qMVnQ&index=1
