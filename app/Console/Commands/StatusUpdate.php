<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        $data = DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select(DB::raw('domains.id, domains.name, domains.status, ranks.rank, ranks.diff, ranks.date'))
            ->take(250)
            ->get();

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

    private function domainArray($data, $nodes) {
        foreach ($data as $site) {
            if (!in_array($site->name, $nodes)) {
                array_push($nodes, $site->name);
            }
        }
        return $nodes;
    }
}