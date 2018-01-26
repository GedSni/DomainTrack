<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class drop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tables:drop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop ranks table';

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
        DB::beginTransaction();
        DB::statement('DROP TABLE ranks');
        DB::statement('DROP TABLE domains');
        DB::statement('DROP TABLE migrations');
        DB::commit();
    }
}
