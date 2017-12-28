<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ranks', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('value')->unsigned()->nullable();
            $table->integer('domain_id')->unsigned();

            $table->foreign('domain_id')
                ->references('id')->on('domains')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['date', 'domain_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranks');
    }
}
