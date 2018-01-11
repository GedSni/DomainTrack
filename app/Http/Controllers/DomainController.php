<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DomainController extends Controller
{
    public function index()
    {
        $dataDay = DB::table('domains')
            ->select(DB::raw('id, name, day_rank, day_diff, day_update_date, status'))
            ->whereRaw('domains.day_update_date = (select MAX(domains.day_update_date) from domains)')
            ->orderBy('day_diff', 'desc')
            ->take(250)
            ->get();
        $dataWeek = DB::table('domains')
            ->select(DB::raw('id, name, day_rank, week_rank, week_diff, week_update_date, status'))
            ->whereRaw('domains.week_update_date = (select MAX(domains.week_update_date) from domains)')
            ->orderBy('week_diff', 'desc')
            ->take(250)
            ->get();
        $dataMonth = DB::table('domains')
            ->select(DB::raw('id, name, day_rank, month_rank, month_diff, month_update_date, status'))
            ->whereRaw('domains.month_update_date = (select MAX(domains.month_update_date) from domains)')
            ->orderBy('month_diff', 'desc')
            ->take(250)
            ->get();

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
        /*$client = new GuzzleClient();
        $requestPromises = [];
        foreach ($data as $site) {
            $requestPromises[$site->name] = $client->headAsync('http://' . $site->name);
        }
        $results = GuzzlePromise\settle($requestPromises)->wait();
        foreach ($data as $site) {
            $site->info = $results[$site->name];
        }
        dd($data);
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




        /*$requests = function ($data) {
            foreach ($data as $site) {
                $uri = 'http://' . $site->name;
                yield new Request('GET', $uri);
            }
        };*/
       /* $client = new GuzzleClient();
        $requests = function ($data) use ($client) {
            foreach ($data as $site) {
                $name = $site->name;
                yield function() use ($client, $name) {
                    return $client->headAsync('http://' . $name);
                };
            }
        };

        $pool = new Pool($client, $requests($data), [
            'concurrency' => 50,
            'fulfilled' => function ($response, $index) use ($data) {
                foreach ($data as $site) {
                    if ($index == $site->name) {
                        $site->info = 'rejected';
                        break;
                    }
                }
            },
            'rejected' => function ($reason, $index) use ($data) {
                foreach ($data as $site) {
                    if ($index == $site->name) {
                        $site->info = 'rejected';
                        break;
                    }
                }
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();

        return $data;*/


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

        //$client = new GuzzleClient();

       /* foreach ($data as $site) {
            $response = $client->request('GET', 'http://' . $site->name, ['http_errors' => false]);
            echo $response->getStatusCode();
        }*/

       /* foreach ($data as $site) {
            $response = $client->head('http://' . $site->name, ['http_errors' => false]);
            echo $response->getStatusCode();
        }*/


       /* $requests = function ($data) {
            foreach ($data as $site) {
                $uri = 'http://' . $site->name;
                yield new Request('GET', $uri);
            }
        };
        $fulfilled = function($result, $index) use ($data) {
            dd($result);
        };
        $rejected = function($reason, $index) use ($data) {

        };
        $promises = $requests($data);
        $each = GuzzlePromise\each_limit($promises, 2, $fulfilled, $rejected);
        $each->wait();*/
        /*for ($i = 0; $i < count($data); $i++) {
            $data[$i]->info = $results[$i]['state'];
        }*/
       // return $data;

       /* $requests = function ($data) {
            $client = new GuzzleClient();
            foreach ($data as $site) {
                $uri = 'http://' . $site->name;
                yield $client->headAsync($uri);
               // yield new Request('HEAD', $uri);
            }
        };*/
       /* $fulfilled = function($result, $index) use ($data) {
            foreach ($data as $site) {
                if ($index == $site->name) {
                    $site->info = 'fulfilled';
                    break;
                }
            }
        };
        $rejected = function($reason, $index) use ($data) {
            foreach ($data as $site) {
                if ($index == $site->name) {
                    $site->info = 'rejected';
                    break;
                }
            }
        };
        $client = new GuzzleClient();
        foreach ($data as $site) {
            $requestPromises[$site->name] = $client->headAsync('http://' . $site->name, ['connect_timeout' => 15, 'timeout' => 15]);
        }

        $each = GuzzlePromise\each_limit($requestPromises, 250, $fulfilled, $rejected);
        $each->wait();
        return $data;*/

        /*$promises = $requests($data);
         $results = GuzzlePromise\settle($promises)->wait();
         for ($i = 0; $i < count($data); $i++) {
             $data[$i]->info = $results[$i]['state'];
         }*/

       /* $client = new GuzzleClient();

        $requests = function () use ($client, $data) {
            foreach ($data as $site) {
                yield $client->getAsync('http://' . $site->name, ['timeout' => 1])
                    ->then(function ($response) use ($site) {
                        echo $response;
                        return [
                            'response' => $response,
                            'site'    => $site
                        ];
                    });
            }
        };

        $promise =  GuzzlePromise\each_limit(
            $requests(),
            3
        // fulfiled
        // rejected
        );
        $promise->wait();*/

       /* $nodes = array();

        foreach ($data as $site) {
            array_push($nodes, 'http://' . $site->name);
        }
       // $nodes = array('http://www.google.com', 'http://www.daniweb.com', 'http://www.yahoo.com');
        $curl_arr = array();
        $master = curl_multi_init();
        for($i = 0, $count=count($nodes); $i < $count; $i++)
        {
            $url =$nodes[$i];
            $curl_arr[$i] = curl_init();
            curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_arr[$i], CURLOPT_URL, $nodes[$i] );
            curl_setopt($curl_arr[$i], CURLOPT_CONNECTTIMEOUT, 20);
            curl_setopt($curl_arr[$i], CURLOPT_NOBODY, true);
            curl_setopt($curl_arr[$i], CURLOPT_HEADER, true);
            curl_setopt($curl_arr[$i], CURLOPT_FOLLOWLOCATION, true);

            curl_multi_add_handle($master, $curl_arr[$i]);
        }
        do {
            curl_multi_exec($master,$running);
        } while($running > 0);
        for($i = 0; $i < $count; $i++)
        {
            echo 'aaaaaaa--------' . "\n";
            $results = curl_multi_getcontent  ( $curl_arr[$i]  );
            var_dump($results);
            echo "\n";
        }
        $end = microtime(true);*/

    }
}

