<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultsalls', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('week_no');
            $table->integer('p1');
            $table->integer('p2');
            $table->integer('p3');
            $table->integer('p4');
            $table->integer('p5');
            $table->integer('p6');
            $table->integer('p7');
            $table->integer('p8');
            $table->integer('p9');
            $table->integer('p10');
            $table->integer('p11');
            $table->integer('p12');
            $table->integer('p13');
            $table->integer('p14');
            $table->integer('p15');
            $table->integer('p16');
            $table->integer('totpts')->default(0);
            $table->timestamps();
            $table->dateTime('created')->nullable();
            $table->dateTime('modified')->nullable();        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultsalls');
    }
}
