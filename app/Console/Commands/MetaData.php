<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DOMDocument;

class MetaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Meta data';

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
        $data = file_get_contents('http://allrecipes.com/');
        $dom = new DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($data);
        libxml_use_internal_errors($internalErrors);
        $img = $dom->getElementsByTagName('title')->item(0);
        echo $img->nodeValue."\n";
        $img = $dom->getElementsByTagName('meta');
        foreach ($img as $im) {
            if ($im->hasAttributes()) {
                foreach ($im->attributes as $attr) {
                    $name = $attr->nodeName;
                    $value = $attr->nodeValue;
                    echo "'$name'='$value'\n";
                }
            }
        }
        $img = $dom->getElementsByTagName('link');
        foreach ($img as $im) {
            if ($im->hasAttribute('rel')) {
                $atr = $im->getAttribute('rel');
                if(strpos($atr, 'icon') !== false) {
                    if ($im->hasAttribute('href')) {
                        echo $im->getAttribute('href')."\n";
                    }
                }
            }
        }

        return;
    }
}
