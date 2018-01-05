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
        $files = [];
        $day = date('D');
        $month = date('d');
        $log_directory = storage_path();
        $domains = $this->argument('domains');
        if (!isset($domains)) {
            $domains = 100000;
        } else {
            $this->info("Domains variable was taken from command arguments");
        }
        $this->call('domain:update');
        $this->info('Loading data files..');
       /* foreach (glob($log_directory . "\*.csv") as $file) {
            $fileDate = new DateTime(substr($file, -14, 10));
            if ($fileDate->format('Y-m-d')) {
                array_push($files, $file);
            }
        }*/
        $this->info('Processing..');
        $files = scandir($log_directory, SCANDIR_SORT_DESCENDING);
        $fileHandle = fopen($log_directory.$files[0], 'r');
        $fileDate = new DateTime(substr($files[0], -14, 10));
        DB::beginTransaction();
        for ($i = 0; $i < $domains; $i++) {
            echo "( " . $i . " / " . $domains . " )\r";
            $line = fgetcsv($fileHandle);
            $newDayRank = $line[0];
            $domain = Domain::firstOrNew(['name' => $line[1]]);
            if ($fileDate->format('Y-m-d') != $domain->day_update_date) {
                $newDayDiff = $domain->day_rank - $newDayRank;
                $domain->day_rank = $newDayRank;
                $domain->day_diff = $newDayDiff;
                $domain->day_update_date = $fileDate;
            }
            if ($day == 'Thu' && $fileDate->format('Y-m-d') != $domain->week_update_date) {
                $newWeekRank = $line[0];
                $newWeekDiff = $domain->week_rank - $newWeekRank;
                $domain->week_rank = $newWeekRank;
                $domain->week_diff = $newWeekDiff;
                $domain->week_update_date = $fileDate;
            }
            if ($month == 14 && $fileDate->format('Y-m-d') != $domain->month_update_date) {
                $newMonthRank = $line[0];
                $newMonthDiff = $domain->month_rank - $newMonthRank;
                $domain->month_rank = $newMonthRank;
                $domain->month_diff = $newMonthDiff;
                $domain->month_update_date = $fileDate;
                Rank::create(
                    [
                        'date' => $fileDate,
                        'domain_id' => $domain->id,
                        'value' => $newMonthRank
                    ]
                );
            }
            $domain->save();
        }
        DB::commit();
        fclose($fileHandle);
        foreach ($files as $file) {
            unlink($file);
        }
        $this->info('Processing ended..');
        $timePost = microtime(true);
        $execTime = $timePost - $timePre;
        $this->info(round($execTime). 's spent overall');
        $this->info('Success!');
    }
}

