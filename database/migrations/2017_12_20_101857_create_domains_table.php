<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{

    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name')->unique();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::beginTransaction();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('domains');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        DB::commit();
    }
}

