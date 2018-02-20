<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Domain;

class UserController extends Controller
{
    public function multiple(Request $request)
    {
        $returnObject = null;
        $names = $request->get('multipleDomains');
        $names = preg_split('/\n|\r/', $names, -1, PREG_SPLIT_NO_EMPTY);
        $data = Domain::whereIn('name', $names)->get();
        foreach ($data as $domain) {
            if (!$domain->favorited()) {
                Auth::user()->favorites()->attach($domain->id);
            }
        }
        if (count($data) == 0) {
            return back()->with('error', 'No domain names were found');
        } elseif (count($names) > count($data)) {
            return back()->with('warning', 'Some of domain names were not found');
        } elseif (count($names) == count($data)) {
            return back()->with('success', 'All domains were added to your favorites');
        }
        return back();
    }

    public function favorite($id)
    {
        Auth::user()->favorites()->attach($id);
        return back();
    }

    public function unfavorite($id)
    {
        Auth::user()->favorites()->detach($id);
        return back();
    }

    public function favorites(Request $request)
    {
        if ($request->query('date') != null) {
            $date = $request->query('date');
            $data = $this->getDataFavorites($date);
            return view('date')
                ->with('data', $data)
                ->with('date', $date);
        } else {
            $yesterday = date("Y-m-d", strtotime("-1 day"));
            $lastMonday = date("Y-m-d", strtotime("-1 week"));
            $firstMonthDay = date("Y-m-d", strtotime("-1 month"));
            $dataDay = $this->getDataFavorites($yesterday);
            $dataWeek = $this->getDataFavorites($lastMonday);
            $dataMonth = $this->getDataFavorites($firstMonthDay);
            $action = "UserController@favorites";
            return view('home')
                ->with('dataDay', $dataDay)
                ->with('dataWeek', $dataWeek)
                ->with('dataMonth', $dataMonth)
                ->with('yesterday', $yesterday)
                ->with('lastMonday', $lastMonday)
                ->with('firstMonthDay', $firstMonthDay)
                ->with('action', $action);
        }
    }

    private function getDataFavorites($interval)
    {
        $data = DB::select("select d1.id, d1.name, d1.status, r1.rank, r1.date,
                                  (select r2.rank
                                  from domains as d2, ranks as r2 
                                  where d2.id = r2.domain_id and d2.id = d1.id and r2.date = :interval)
                                   - r1.rank as diff
                                  from domains as d1, ranks as r1, favorites as f
                                  where f.domain_id = d1.id and f.user_id = :user and d1.id = r1.domain_id and r1.date = (select MAX(ranks.date) from ranks)
                                  order by diff desc"
            , ["interval" => $interval, "user" => Auth::id()]);
        return $data;
    }
}
