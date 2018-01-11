<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Domain;

class CheckDomainStatusCode extends Command
{
    protected $signature = 'domain:status';
    protected $description = 'Check domain\'s status code';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Getting domains\' data');
        $dataDay = DB::table('domains')
            ->select(DB::raw('id, name, day_rank, day_diff, day_update_date'))
            ->whereRaw('domains.day_update_date = (select MAX(domains.day_update_date) from domains)')
            ->orderBy('day_diff', 'desc')
            ->take(250)
            ->get();
        $dataWeek = DB::table('domains')
            ->select(DB::raw('id, name, day_rank, week_rank, week_diff, week_update_date'))
            ->whereRaw('domains.week_update_date = (select MAX(domains.week_update_date) from domains)')
            ->orderBy('week_diff', 'desc')
            ->take(250)
            ->get();
        $dataMonth = DB::table('domains')
            ->select(DB::raw('id, name, day_rank, month_rank, month_diff, month_update_date'))
            ->whereRaw('domains.month_update_date = (select MAX(domains.month_update_date) from domains)')
            ->orderBy('month_diff', 'desc')
            ->take(250)
            ->get();
        $this->info('Processing cURL requests');
        $nodes = array();
        $nodes = $this->domainArray($dataDay, $nodes);
        $nodes = $this->domainArray($dataWeek, $nodes);
        $nodes = $this->domainArray($dataMonth, $nodes);
        $curl_arr = array();
        $master = curl_multi_init();
        for($i = 0, $count=count($nodes); $i < $count; $i++) {
            $curl_arr[$i] = curl_init();
            curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_arr[$i], CURLOPT_VERBOSE, true);
            curl_setopt($curl_arr[$i], CURLOPT_CAINFO, storage_path() . '/cacert.pem');
            curl_setopt($curl_arr[$i], CURLOPT_CAPATH, storage_path() . '/cacert.pem');
            curl_setopt($curl_arr[$i], CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_arr[$i], CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl_arr[$i], CURLOPT_URL, 'http://' . $nodes[$i] );
            curl_setopt($curl_arr[$i], CURLOPT_NOBODY, true);
            curl_setopt($curl_arr[$i], CURLOPT_HEADER, true);
            curl_setopt($curl_arr[$i], CURLOPT_FOLLOWLOCATION, false);
            curl_multi_add_handle($master, $curl_arr[$i]);
        }
        do {
            curl_multi_exec($master,$running);
        } while($running > 0);
        for($i = 0; $i < $count; $i++) {
            $domain = Domain::where('name', $nodes[$i])->first();
            $httpCode = curl_getinfo($curl_arr[$i], CURLINFO_HTTP_CODE);
            $results = curl_multi_getcontent  ( $curl_arr[$i]  );
            var_dump($i);
            var_dump($domain->name);
            var_dump($httpCode);
            var_dump($results);
            if ($httpCode < 400 || $httpCode == 405 || $httpCode == 501) {
                $domain->status = true;
            } else {
                $domain->status = false;
            }
            $domain->save();
        }
        $this->info('Success!');
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
