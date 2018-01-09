<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise as GuzzlePromise;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;

class DomainController extends Controller
{
    public function index()
    {
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
        $dataDay = $this->checkDomainsStatus($dataDay);
        $dataWeek = $this->checkDomainsStatus($dataWeek);
        $dataMonth = $this->checkDomainsStatus($dataMonth);
        return view('home')
            ->with('dataDay', $dataDay)
            ->with('dataWeek', $dataWeek)
            ->with('dataMonth', $dataMonth);
    }

    public function oldData()
    {
        $dates = DB::table('ranks')
            ->select(DB::raw('distinct date'))
            ->orderBy('date', 'desc')
            ->get();
        if (isset($dates[2]->date)) {
            $dataMonths3 = DB::table('domains')
                ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
                ->select(DB::raw('domains.id, domains.name, domains.day_rank, ranks.domain_id, ranks.date, ranks.value'))
                ->where('ranks.date', '=', $dates[2]->date)
                ->orderByRaw('domains.day_rank - ranks.value DESC')
                ->take(250)
                ->get();
            if (isset($dates[5]->date)) {
                $dataMonths6 = DB::table('domains')
                    ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
                    ->select(DB::raw('domains.id, domains.name, domains.day_rank, ranks.domain_id, ranks.date, ranks.value'))
                    ->where('ranks.date', '=', $dates[5]->date)
                    ->orderByRaw('domains.day_rank - ranks.value DESC')
                    ->take(250)
                    ->get();
            } else {
                return view('oldData')->with('dataMonths3',  $dataMonths3);
            }
            if (isset($dates[11]->date)) {
                $dataMonths12 = DB::table('domains')
                    ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
                    ->select(DB::raw('domains.id, domains.name, domains.day_rank, ranks.domain_id, ranks.date, ranks.value'))
                    ->where('ranks.date', '=', $dates[11]->date)
                    ->orderByRaw('domains.day_rank - ranks.value DESC')
                    ->take(250)
                    ->get();
                return view('oldData')
                    ->with('dataMonths3',  $dataMonths3)
                    ->with('dataMonths6', $dataMonths6)
                    ->with('dataMonths12', $dataMonths12);

            } else {
                return view('oldData')
                    ->with('dataMonths3',  $dataMonths3)
                    ->with('dataMonths6', $dataMonths6);
            }
        } else {
            return view('oldData');
        }
    }

    private function checkDomainsStatus($data) {
       /* $client = new GuzzleClient();
        $requestPromises = [];
        foreach ($data as $site) {
            $requestPromises[$site->name] = $client->getAsync('http://' . $site->name);
        }

        //dd($results);
        foreach ($data as $site) {
            $site->info = $results[$site->name];
        }
        return $data;*/

        /*$curl = new CurlMultiHandler();
        $client = new GuzzleClient();
        $requestPromises = [];
        foreach ($data as $site) {
            $requestPromises[$site->name] = $client->getAsync('http://' . $site->name);
        }
        $aggregate = GuzzlePromise\all($requestPromises);
        while (!GuzzlePromise\is_settled($aggregate)) {
            $curl->tick();
        }*/



        /*$client = new GuzzleClient();
        $requests = function ($data) {
            foreach ($data as $site) {
                $uri = 'http://' . $site->name;
                yield new Request('GET', $uri);
            }
        };
        $pool = new Pool($client, $requests($data), [
            'concurrency' => 2,
            'fulfilled' => function ($response, $index) {

            },
            'rejected' => function ($reason, $index) {

            },
        ]);
        $promise = $pool->promise();
        $promise->wait();*/




        /*$requests = function ($data) {
            foreach ($data as $site) {
                $uri = 'http://' . $site->name;
                yield new Request('GET', $uri);
            }
        };
        $fulfilled = function($result, $index) {
           echo $index . " ";

        };
        $rejected = function($reason, $index) {
        };
        $promises = $requests($data);
        $each = GuzzlePromise\each_limit($promises, 50, $fulfilled, $rejected);
        $each->wait();*/

        $requests = function ($data) {
            foreach ($data as $site) {
                $uri = 'http://' . $site->name;
                yield new Request('GET', $uri);
            }
        };
        $promises = $requests($data);
        $results = GuzzlePromise\settle($promises)->wait();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->info = $results[$i]['state'];
        }
        return $data;
    }
}

