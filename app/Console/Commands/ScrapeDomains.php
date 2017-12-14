<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapeDomains extends Command
{
    protected $signature = 'scrape:domains';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

    }
}
