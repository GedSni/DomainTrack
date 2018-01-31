<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Domain;

class StatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check domain\'s status code';

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
        $this->info('Getting domains\' data');
        $yesterday = date("Y-m-d", strtotime("yesterday"));
        $lastMonday = date("Y-m-d", strtotime("last monday"));
        $firstMonthDay =  date("Y-m-d", strtotime("first day of this month"));
        $this->info("wat");
        $dataDay = $this->getData($yesterday);
        $this->info("wat");
        $this->info('Processing cURL requests (1/3)');
        $this->statusCheck($dataDay);
        unset($dataDay);
        $dataWeek = $this->getData($lastMonday);
        $this->info('Processing cURL requests (2/3)');
        $this->statusCheck($dataWeek);
        unset($dataWeek);
        $dataMonth = $this->getData($firstMonthDay);
        $this->info('Processing cURL requests (3/3)');
        $this->statusCheck($dataMonth);
        unset($dataMonth);
        $this->info('Success!');
    }

    private function statusCheck($nodes) {
        $curl_arr = array();
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2';
        $master = curl_multi_init();
        for($i = 0, $count=count($nodes); $i < $count; $i++) {
            $curl_arr[$i] = curl_init();
            curl_setopt($curl_arr[$i],CURLOPT_USERAGENT, $userAgent);
            //curl_setopt($curl_arr[$i], CURLOPT_CAINFO, storage_path() . '/cacert.pem');
            //curl_setopt($curl_arr[$i], CURLOPT_CAPATH, storage_path() . '/cacert.pem');
            //curl_setopt($curl_arr[$i], CURLOPT_SSL_VERIFYPEER, true);
            //curl_setopt($curl_arr[$i], CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl_arr[$i], CURLOPT_AUTOREFERER, true);
            curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_arr[$i], CURLOPT_VERBOSE, true);
            curl_setopt($curl_arr[$i], CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($curl_arr[$i], CURLOPT_TIMEOUT, 20);
            curl_setopt($curl_arr[$i], CURLOPT_NOBODY, true);
            curl_setopt($curl_arr[$i], CURLOPT_HEADER, true);
            curl_setopt($curl_arr[$i], CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl_arr[$i], CURLOPT_URL, 'http://' . $nodes[$i]->name );
            curl_multi_add_handle($master, $curl_arr[$i]);
        }
        do {
            curl_multi_exec($master,$running);
        } while($running > 0);
        for($i = 0; $i < $count; $i++) {
            $domain = Domain::where('name', $nodes[$i]->name)->first();
            $httpCode = curl_getinfo($curl_arr[$i], CURLINFO_HTTP_CODE);
            echo "\n";
            if ($httpCode < 400 /*&& $httpCode != 0*/ || $httpCode == 405 || $httpCode == 501) {
                $domain->status = true;
            } else {
                $domain->status = false;
            }
            $domain->save();
        }
    }

    private function getData($interval)
    {
        $data = DB::select("select d1.name,
                                  (select r2.rank
                                  from domains as d2, ranks as r2 
                                  where d2.id = r2.domain_id and d2.id = d1.id and r2.date = :interval)
                                   - r1.rank as diff
                                  from domains as d1, ranks as r1
                                  where d1.id = r1.domain_id and r1.date = (select MAX(ranks.date) from ranks)
                                  order by diff desc
                                  LIMIT 250"
            , array( 'interval' => $interval));
        return $data;
    }
}
