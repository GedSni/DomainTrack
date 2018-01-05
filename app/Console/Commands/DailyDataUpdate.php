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
    protected $description = 'Domain data daily update';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Defining variables');
        $timePre = microtime(true);
        $day = date('D');
        $month = date('d');
        $log_directory = storage_path();
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
        $fileHandle = fopen("$log_directory/top-1m.csv", 'r');
        $fileDate = date("Y-m-d");
        DB::beginTransaction();
        for ($i = 0; $i < $domains; $i++) {
            $saved = false;
            echo "( " . $i . " / " . $domains . " )\r";
            $line = fgetcsv($fileHandle);
            $newDayRank = $line[0];
            $domain = Domain::firstOrNew(['name' => $line[1]]);
            if ($fileDate != $domain->day_update_date) {
                $newDayDiff = $domain->day_rank - $newDayRank;
                $domain->day_rank = $newDayRank;
                $domain->day_diff = $newDayDiff;
                $domain->day_update_date = $fileDate;
            }
            if ($day == 'Fri' && $fileDate != $domain->week_update_date) {
                $newWeekRank = $line[0];
                $newWeekDiff = $domain->week_rank - $newWeekRank;
                $domain->week_rank = $newWeekRank;
                $domain->week_diff = $newWeekDiff;
                $domain->week_update_date = $fileDate;
            }
            if ($month == 5 && $fileDate != $domain->month_update_date) {
                $newMonthRank = $line[0];
                $newMonthDiff = $domain->month_rank - $newMonthRank;
                $domain->month_rank = $newMonthRank;
                $domain->month_diff = $newMonthDiff;
                $domain->month_update_date = $fileDate;
                $domain->save();
                $saved = true;
                Rank::create(
                    [
                        'date' => $fileDate,
                        'domain_id' => $domain->id,
                        'value' => $newMonthRank
                    ]
                );
            }
            if(!$saved) {
                $domain->save();
            }
        }
        DB::commit();
        fclose($fileHandle);
        unlink("$log_directory/top-1m.csv");
        $this->info('Processing ended..');
        $timePost = microtime(true);
        $execTime = $timePost - $timePre;
        $this->info(round($execTime). 's spent overall');
        $this->info('Success!');
    }
}

