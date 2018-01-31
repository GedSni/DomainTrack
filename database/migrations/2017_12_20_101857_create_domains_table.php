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
            $table->String('name');
            $table->boolean('status')->nullable();
            $table->unique(['name', 'status']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ranks');
        Schema::dropIfExists('domains');
    }
}

