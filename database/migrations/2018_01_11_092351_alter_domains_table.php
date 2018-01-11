<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDomainsTable extends Migration
{
    public function up()
    {
        Schema::table('domains', function($table) {
            $table->boolean('status')->nullable();
        });
    }

    public function down()
    {
        Schema::table('domains', function($table) {
            $table->dropColumn('status');
        });
    }
}
