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

            $table->integer('day_rank')->nullable();
            $table->integer('day_diff')->nullable();
            $table->date('day_update_date')->nullable();

            $table->integer('week_rank')->nullable();
            $table->integer('week_diff')->nullable();
            $table->date('week_update_date')->nullable();

            $table->integer('month_rank')->nullable();
            $table->integer('month_diff')->nullable();
            $table->date('month_update_date')->nullable();

            $table->index('day_diff');
            $table->index('week_diff');
            $table->index('month_diff');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('domains');
    }
}

