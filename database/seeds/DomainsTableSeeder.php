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
        $log_directory = "./domains/";
        $domains = 20;
        $files = scandir($log_directory, SCANDIR_SORT_DESCENDING);
        $fileHandle = fopen($log_directory.$files[0], 'r');
        $fileDate = new DateTime(substr($files[0], -14, 10));
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
