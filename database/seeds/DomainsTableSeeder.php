<?php

use Illuminate\Database\Seeder;

class DomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $log_directory = storage_path();
        $domains = 250;
        $fileHandle = fopen("$log_directory/top-1m.csv", 'r');
        $fileDate = date("Y-m-d");
        for ($i = 0; $i < $domains; $i++) {
            $line = fgetcsv($fileHandle);
            DB::table('domains')->updateOrInsert([
                    'name' => $line[1],
                ],
                [
                    'day_rank' => $line[0],
                    'day_diff' => 0,
                    'day_update_date' => $fileDate,
                    'week_rank' => $line[0],
                    'week_diff' => 0,
                    'week_update_date' => $fileDate,
                    'month_rank' => $line[0],
                    'month_diff' => 0,
                    'month_update_date' => $fileDate,
            ]);
        }
        fclose($fileHandle);
    }
}
