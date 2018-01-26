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
    protected $signature = 'domain:stat';

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
        $dataDay = $this->getData($yesterday);
        $dataWeek = $this->getData($lastMonday);
        $dataMonth = $this->getData($firstMonthDay);
        $this->info('Processing cURL requests');
        $nodes = array();
        $nodes = $this->domainArray($dataDay, $nodes);
        $nodes = $this->domainArray($dataWeek, $nodes);
        $nodes = $this->domainArray($dataMonth, $nodes);
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
            curl_setopt($curl_arr[$i], CURLOPT_URL, 'http://' . $nodes[$i] );
            curl_multi_add_handle($master, $curl_arr[$i]);
        }
        do {
            curl_multi_exec($master,$running);
        } while($running > 0);
        for($i = 0; $i < $count; $i++) {
            $domain = Domain::where('name', $nodes[$i])->first();
            $httpCode = curl_getinfo($curl_arr[$i], CURLINFO_HTTP_CODE);
            var_dump($i);
            var_dump($domain->name);
            var_dump($httpCode);
            echo "\n";
            if ($httpCode < 400 && $httpCode != 0 || $httpCode == 405 || $httpCode == 501) {
                $domain->status = true;
            } else {
                $domain->status = false;
            }
            $domain->save();
        }
        $this->info('Success!');
    }

    private function getData($time)
    {
        $data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.id, domains.name, domains.status, ranks.rank, ranks.date'))
            ->where('ranks.date', '=', $time)
            ->orderBy('ranks.rank', 'asc')
            ->take(250)
            ->get();
        return $data;
    }

    private function domainArray($data, $nodes) {
        foreach ($data as $site) {
            if (!in_array($site->name, $nodes)) {
                array_push($nodes, $site->name);
            }
        }
        return $nodes;
    }
}
