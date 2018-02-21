<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Http\Request;
use App\Domain;
use Cache;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('date') != null) {
            $date = $request->query('date');
            $data = $this->fromCache($date);
            return view('date')
                ->with('data', $data)
                ->with('date', $date);
        } else {
            $yesterday = date("Y-m-d", strtotime("-1 day"));
            $lastMonday = date("Y-m-d", strtotime("-1 week"));
            $firstMonthDay = date("Y-m-d", strtotime("-1 month"));
            $dataDay = $this->fromCache($yesterday);
            $dataWeek = $this->fromCache($lastMonday);
            $dataMonth = $this->fromCache($firstMonthDay);
            $action = "DomainController@index";
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

    public function show($name)
    {
        $data = $this->getDataIndividual($name);
        if (!$data->isEmpty()) {
            $domain = Domain::where('name', '=', $name)->get();
            $data->isFavorited = $domain[0]->favorited();
            $data->startDate = $data->min('date');
            $data->minRank = $data->min('rank');
            $data->maxRank = $data->max('rank');
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
            if (Cache::has($name.' dns')) {
                $dns = Cache::get($name.' dns');
            } else {
                if(checkdnsrr( $name,"ANY")) {
                    $dns = dns_get_record($name, DNS_ANY);
                    Cache::put($name.' dns', $dns, 1440);
                } else {
                    $dns = null;
                }
            }
            $data->dns = $dns;
            if (Cache::has($name)) {
                $whoIs = Cache::get($name);
            } else {
                $whoIs = $this->whoIsData($name);
                $whoIs = $this->formatWhoIs($whoIs);
                Cache::put($name, $whoIs, 1440);
                return view('domain')
                    ->with('data', $data)
                    ->with('whoIs', $whoIs);
            }
            return view('domain')
                ->with('data', $data)
                ->with('whoIs', $whoIs);
        }
        return view('domain')
            ->with('data', $data);
    }

    public function search(Request $request)
    {
        $name = $request->get('name');
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $lastMonday = date("Y-m-d", strtotime("-1 week"));
        $firstMonthDay = date("Y-m-d", strtotime("-1 month"));
        $dataDay = $this->getDataByName($yesterday, $name);
        $dataWeek = $this->getDataByName($lastMonday, $name);
        $dataMonth = $this->getDataByName($firstMonthDay, $name);
        $action = 'DomainController@index';
        return view('home')
            ->with('dataDay', $dataDay)
            ->with('dataWeek', $dataWeek)
            ->with('dataMonth', $dataMonth)
            ->with('yesterday', $yesterday)
            ->with('lastMonday', $lastMonday)
            ->with('firstMonthDay', $firstMonthDay)
            ->with('action', $action);
    }

    private function getData($interval)
    {
        $data = DB::select("select d1.id, d1.name, d1.status, r1.rank, r1.date,
                                  (select r2.rank
                                  from domains as d2, ranks as r2 
                                  where d2.id = r2.domain_id and d2.id = d1.id and r2.date = :interval)
                                   - r1.rank as diff
                                  from domains as d1, ranks as r1
                                  where d1.id = r1.domain_id and r1.date = (select MAX(ranks.date) from ranks)
                                  order by diff desc
                                  LIMIT 50"
            , array( 'interval' => $interval));
        return $data;
    }

    private function getDataByName($interval, $name)
    {
        $name = '%'.$name.'%';
        $data = DB::select("select d1.id, d1.name, d1.status, r1.rank, r1.date,
                                  (select r2.rank
                                  from domains as d2, ranks as r2 
                                  where d2.id = r2.domain_id and d2.id = d1.id and r2.date = :interval)
                                   - r1.rank as diff
                                  from domains as d1, ranks as r1
                                  where d1.name like :name and d1.id = r1.domain_id and r1.date = (select MAX(ranks.date) from ranks)
                                  order by diff desc
                                  LIMIT 50"
            , array( 'interval' => $interval, 'name' => $name));
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

    private function fromCache($key)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $data = $this->getData($key);
            Cache::put($key, $data, 1440);
            return $data;
        }
    }

    private function formatWhoIs($whoIs)
    {
        if ($whoIs === 'Not available') {
            return $whoIs;
        }
        $lines = array();
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $whoIs) as $line) {
            array_push($lines, $line);
        }
        $index = $this->array_search_partial($lines, 'URL of the ICANN Whois Inaccuracy Complaint Form');
        if ($index) {
            $lines = array_slice($lines,0, $index);
            return $lines;
        }
        $index = $this->array_search_partial($lines, 'Record maintained by');
        if ($index) {
            $lines = array_slice($lines,0, $index);
            return $lines;
        }
        $index = $this->array_search_partial($lines, 'For more information on Whois status codes');
        if ($index) {
            $lines = array_slice($lines,0, $index);
            return $lines;
        }
        $index = $this->array_search_partial($lines, 'This WHOIS information is provided for free by');
        if ($index) {
            $lines = array_slice($lines,0, $index);
            return $lines;
        }
        $index = $this->array_search_partial($lines, 'The Registry contains ONLY');
        if ($index) {
            $lines = array_slice($lines,0, $index);
            return $lines;
        }
        $index = $this->array_search_partial($lines, 'Access to .IN WHOIS information is provided to assist persons');
        if ($index) {
            unset($lines[$index]);
            return $lines;
        }
        $index = $this->array_search_partial($lines, 'NOTICE:');
        if ($index) {
            $lines = array_slice($lines,0, $index);
            return $lines;
        }
        $index = $this->array_search_partial($lines, 'Conditions of use for the whois service');
        if ($index) {
            return 'Not available';
        }
        return $lines;
    }

    private function array_search_partial($arr, $keyword) {
        foreach($arr as $index => $string) {
            if (strpos($string, $keyword) !== FALSE)
                return $index;
        }
        return false;
    }

    private function whoIsData($domain)
    {
        $whoisservers = array(
            "ac" => "whois.nic.ac", // Ascension Island
            "ae" => "whois.nic.ae", // United Arab Emirates
            "aero"=>"whois.aero",
            "af" => "whois.nic.af", // Afghanistan
            "ag" => "whois.nic.ag", // Antigua And Barbuda
            "ai" => "whois.ai", // Anguilla
            "al" => "whois.ripe.net", // Albania
            "am" => "whois.amnic.net",  // Armenia
            "arpa" => "whois.iana.org",
            "as" => "whois.nic.as", // American Samoa
            "asia" => "whois.nic.asia",
            "at" => "whois.nic.at", // Austria
            "au" => "whois.aunic.net", // Australia
            "ax" => "whois.ax", // Aland Islands
            "az" => "whois.ripe.net", // Azerbaijan
            "be" => "whois.dns.be", // Belgium
            "bg" => "whois.register.bg", // Bulgaria
            "bi" => "whois.nic.bi", // Burundi
            "biz" => "whois.biz",
            "bj" => "whois.nic.bj", // Benin
            "bn" => "whois.bn", // Brunei Darussalam
            "bo" => "whois.nic.bo", // Bolivia
            "br" => "whois.registro.br", // Brazil
            "bt" => "whois.netnames.net", // Bhutan
            "by" => "whois.cctld.by", // Belarus
            "bz" => "whois.belizenic.bz", // Belize
            "ca" => "whois.cira.ca", // Canada
            "cat" => "whois.cat", // Spain
            "cc" => "whois.nic.cc", // Cocos (Keeling) Islands
            "cd" => "whois.nic.cd", // Congo, The Democratic Republic Of The
            "ch" => "whois.nic.ch", // Switzerland
            "ci" => "whois.nic.ci", // Cote d'Ivoire
            "ck" => "whois.nic.ck", // Cook Islands
            "cl" => "whois.nic.cl", // Chile
            "cn" => "whois.cnnic.net.cn", // China
            "co" => "whois.nic.co", // Colombia
            "com" => "whois.verisign-grs.com",
            "coop" => "whois.nic.coop",
            "cx" => "whois.nic.cx", // Christmas Island
            "cz" => "whois.nic.cz", // Czech Republic
            "de" => "whois.denic.de", // Germany
            "dk" => "whois.dk-hostmaster.dk", // Denmark
            "dm" => "whois.nic.dm", // Dominica
            "dz" => "whois.nic.dz", // Algeria
            "ec" => "whois.nic.ec", // Ecuador
            "edu" => "whois.educause.edu",
            "ee" => "whois.eenet.ee", // Estonia
            "eg" => "whois.ripe.net", // Egypt
            "es" => "whois.nic.es", // Spain
            "eu" => "whois.eu",
            "fi" => "whois.ficora.fi", // Finland
            "fo" => "whois.nic.fo", // Faroe Islands
            "fr" => "whois.nic.fr", // France
            "gd" => "whois.nic.gd", // Grenada
            "gg" => "whois.gg", // Guernsey
            "gi" => "whois2.afilias-grs.net", // Gibraltar
            "gl" => "whois.nic.gl", // Greenland (Denmark)
            "gov" => "whois.nic.gov",
            "gs" => "whois.nic.gs", // South Georgia And The South Sandwich Islands
            "gy" => "whois.registry.gy", // Guyana
            "hk" => "whois.hkirc.hk", // Hong Kong
            "hn" => "whois.nic.hn", // Honduras
            "hr" => "whois.dns.hr", // Croatia
            "ht" => "whois.nic.ht", // Haiti
            "hu" => "whois.nic.hu", // Hungary
            "ie" => "whois.domainregistry.ie", // Ireland
            "il" => "whois.isoc.org.il", // Israel
            "im" => "whois.nic.im", // Isle of Man
            "in" => "whois.inregistry.net", // India
            "info" => "whois.afilias.net",
            "int" => "whois.iana.org",
            "io" => "whois.nic.io", // British Indian Ocean Territory
            "iq" => "whois.cmc.iq", // Iraq
            "ir" => "whois.nic.ir", // Iran, Islamic Republic Of
            "is" => "whois.isnic.is", // Iceland
            "it" => "whois.nic.it", // Italy
            "je" => "whois.je", // Jersey
            "jobs" => "jobswhois.verisign-grs.com",
            "jp" => "whois.jprs.jp", // Japan
            "ke" => "whois.kenic.or.ke", // Kenya
            "kg" => "www.domain.kg", // Kyrgyzstan
            "ki" => "whois.nic.ki", // Kiribati
            "kr" => "whois.kr", // Korea, Republic Of
            "kz" => "whois.nic.kz", // Kazakhstan
            "la" => "whois.nic.la", // Lao People's Democratic Republic
            "li" => "whois.nic.li", // Liechtenstein
            "lt" => "whois.domreg.lt", // Lithuania
            "lu" => "whois.dns.lu", // Luxembourg
            "lv" => "whois.nic.lv", // Latvia
            "ly" => "whois.nic.ly", // Libya
            "ma" => "whois.iam.net.ma", // Morocco
            "md" => "whois.nic.md", // Moldova
            "me" => "whois.nic.me", // Montenegro
            "mg" => "whois.nic.mg", // Madagascar
            "mil" => "whois.nic.mil",
            "ml" => "whois.dot.ml", // Mali
            "mn" => "whois.nic.mn", // Mongolia
            "mo" => "whois.monic.mo", // Macao
            "mobi" => "whois.dotmobiregistry.net",
            "mp" => "whois.nic.mp", // Northern Mariana Islands
            "ms" => "whois.nic.ms", // Montserrat
            "mu" => "whois.nic.mu", // Mauritius
            "museum" => "whois.museum",
            "mx" => "whois.mx", // Mexico
            "my" => "whois.domainregistry.my", // Malaysia
            "na" => "whois.na-nic.com.na", // Namibia
            "name" => "whois.nic.name",
            "nc" => "whois.nc", // New Caledonia
            "net" => "whois.verisign-grs.net",
            "nf" => "whois.nic.nf", // Norfolk Island
            "ng" => "whois.nic.net.ng", // Nigeria
            "nl" => "whois.domain-registry.nl", // Netherlands
            "no" => "whois.norid.no", // Norway
            "nu" => "whois.nic.nu", // Niue
            "nz" => "whois.srs.net.nz", // New Zealand
            "om" => "whois.registry.om", // Oman
            "org" => "whois.pir.org",
            "pe" => "kero.yachay.pe", // Peru
            "pf" => "whois.registry.pf", // French Polynesia
            "pl" => "whois.dns.pl", // Poland
            "pm" => "whois.nic.pm", // Saint Pierre and Miquelon (France)
            "post" => "whois.dotpostregistry.net",
            "pr" => "whois.nic.pr", // Puerto Rico
            "pro" => "whois.dotproregistry.net",
            "pt" => "whois.dns.pt", // Portugal
            "pw" => "whois.nic.pw", // Palau
            "qa" => "whois.registry.qa", // Qatar
            "re" => "whois.nic.re", // Reunion (France)
            "ro" => "whois.rotld.ro", // Romania
            "rs" => "whois.rnids.rs", // Serbia
            "ru" => "whois.tcinet.ru", // Russian Federation
            "sa" => "whois.nic.net.sa", // Saudi Arabia
            "sb" => "whois.nic.net.sb", // Solomon Islands
            "sc" => "whois2.afilias-grs.net", // Seychelles
            "se" => "whois.iis.se", // Sweden
            "sg" => "whois.sgnic.sg", // Singapore
            "sh" => "whois.nic.sh", // Saint Helena
            "si" => "whois.arnes.si", // Slovenia
            "sk" => "whois.sk-nic.sk", // Slovakia
            "sm" => "whois.nic.sm", // San Marino
            "sn" => "whois.nic.sn", // Senegal
            "so" => "whois.nic.so", // Somalia
            "st" => "whois.nic.st", // Sao Tome And Principe
            "su" => "whois.tcinet.ru", // Russian Federation
            "sx" => "whois.sx", // Sint Maarten (dutch Part)
            "sy" => "whois.tld.sy", // Syrian Arab Republic
            "tc" => "whois.meridiantld.net", // Turks And Caicos Islands
            "tel" => "whois.nic.tel",
            "tf" => "whois.nic.tf", // French Southern Territories
            "th" => "whois.thnic.co.th", // Thailand
            "tj" => "whois.nic.tj", // Tajikistan
            "tk" => "whois.dot.tk", // Tokelau
            "tl" => "whois.nic.tl", // Timor-leste
            "tm" => "whois.nic.tm", // Turkmenistan
            "tn" => "whois.ati.tn", // Tunisia
            "to" => "whois.tonic.to", // Tonga
            "tp" => "whois.nic.tl", // Timor-leste
            "tr" => "whois.nic.tr", // Turkey
            "travel" => "whois.nic.travel",
            "tv" => "tvwhois.verisign-grs.com", // Tuvalu
            "tw" => "whois.twnic.net.tw", // Taiwan
            "tz" => "whois.tznic.or.tz", // Tanzania, United Republic Of
            "ua" => "whois.ua", // Ukraine
            "ug" => "whois.co.ug", // Uganda
            "uk" => "whois.nic.uk", // United Kingdom
            "us" => "whois.nic.us", // United States
            "uy" => "whois.nic.org.uy", // Uruguay
            "uz" => "whois.cctld.uz", // Uzbekistan
            "vc" => "whois2.afilias-grs.net", // Saint Vincent And The Grenadines
            "ve" => "whois.nic.ve", // Venezuela
            "vg" => "whois.adamsnames.tc", // Virgin Islands, British
            "wf" => "whois.nic.wf", // Wallis and Futuna
            "ws" => "whois.website.ws", // Samoa
            "xxx" => "whois.nic.xxx",
            "yt" => "whois.nic.yt", // Mayotte
            "yu" => "whois.ripe.net"
        );
        $domain_parts = explode(".", $domain);
        $tld = strtolower(array_pop($domain_parts));
        if( isset($whoisservers[$tld])) {
            $whoisserver = $whoisservers[$tld];
            if(!$whoisserver) {
                return "Error: No appropriate Whois server found for $domain domain!";
            }
            $result = $this->getWhoIsData($whoisserver, $domain);
            if(!$result) {
                return "Error: No results retrieved from $whoisserver server for $domain domain!";
            }
            else {
                while(strpos($result, "Whois Server:") !== FALSE){
                    preg_match("/Whois Server: (.*)/", $result, $matches);
                    $secondary = $matches[1];
                    if($secondary) {
                        $result = $this->getWhoIsData($secondary, $domain);
                        $whoisserver = $secondary;
                    }
                }
            }
            return "$domain domain lookup results from $whoisserver server:\n\n" . $result;
        } else {
            return "Not available";
        }
    }

    private function getWhoIsData($whoisserver, $domain)
    {
        $port = 43;
        $timeout = 10;
        $fp = @fsockopen($whoisserver, $port, $errno, $errstr, $timeout) or die("Socket Error " . $errno . " - " . $errstr);fputs($fp, $domain . "\r\n");
        $out = "";
        while (!feof($fp)){
            $out .= fgets($fp);
        }
        fclose($fp);
        $res = "";
        if ((strpos(strtolower($out), "error") === FALSE) && (strpos(strtolower($out), "not allocated") === FALSE)) {
            $rows = explode("\n", $out);
            foreach($rows as $row) {
                $row = trim($row);
                if(($row != '') && ($row{0} != '#') && ($row{0} != '%')) {
                    $res .= $row."\n";
                }
            }
        }
        return $res;
    }
}

