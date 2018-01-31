<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRanksTable extends Migration
{

    public function up()
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('domain_id')->unsigned();
            $table->date('date')->nullable();
            $table->integer('rank')->nullable();
            $table->unique(['date', 'domain_id']);
            $table->index(['rank', 'date']);
            $table->foreign('domain_id')
                ->references('id')->on('domains')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

}

