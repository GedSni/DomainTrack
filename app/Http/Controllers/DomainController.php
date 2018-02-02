<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\Input;

class DomainController extends Controller
{
    public function index()
    {
        /*$yesterday = date("Y-m-d", strtotime("yesterday"));
        $lastMonday = date("Y-m-d", strtotime("last monday"));
        $firstMonthDay =  date("Y-m-d", strtotime("first day of this month"));*/

        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $lastMonday = date("Y-m-d", strtotime("-1 week"));
        $firstMonthDay = date("Y-m-d", strtotime("-1 month"));
        $dataDay = $this->getData($yesterday);
        $dataWeek = $this->getData($lastMonday);
        $dataMonth = $this->getData($firstMonthDay);
        return view('home')
            ->with('dataDay', $dataDay)
            ->with('dataWeek', $dataWeek)
            ->with('dataMonth', $dataMonth)
            ->with('yesterday', $yesterday)
            ->with('lastMonday', $lastMonday)
            ->with('firstMonthDay', $firstMonthDay);
    }

    public function show($name)
    {
        $data = $this->getDataIndividual($name);
        $data->startDate = $data->min('date');
        $data->minRank = $data->min('rank');
        $data->maxRank = $data->max('rank');
        $data[count($data)-1]->delta = 0;
        for ($i = 0; $i < count($data)-1; $i++) {
            $data[$i]->delta = $data[$i+1]->rank - $data[$i]->rank;
        }
        $history = \Lava::DataTable();
        $history->addDateColumn('Date');
        $history->addNumberColumn('Rank');
        foreach ($data as $row) {
            $history->addRow([$row->date, $row->rank]);
        }
        \Lava::LineChart('History', $history, [
            'lineWidth' => 3,
            'pointSize' => 7,
            'legend' => [
                'position' => 'none'
            ],
            'title' => 'Rank history',
            'vAxis' => [
                'direction' => -1,
            ],
        ]);
        return view('domain')
            ->with('data', $data);
    }

    public function customDate()
    {
        $date = Input::get( 'date' );
        $data = $this->getData($date);
        $data = array_slice($data, 0, 250);
        return response()->json([
            'view' => view('date')
                ->with('data', $data)
                ->with('date', $date)
                ->render(),
        ]);
    }

    private function getData($interval)
    {
        $data = DB::select("select d1.name, d1.status, r1.rank, r1.date,
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

    private function getDataIndividual($name)
    {
        $data= DB::table('domains')
            ->join('ranks', 'domains.id', '=', 'ranks.domain_id')
            ->select('domains.*', 'ranks.*')
            ->where('domains.name', '=', $name)
            ->orderBy('ranks.date', 'desc')
            ->get();
        return $data;
    }
}
