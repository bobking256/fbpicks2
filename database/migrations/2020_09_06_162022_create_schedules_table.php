<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('week_no');
            $table->integer('hometeam_id');
            $table->integer('awayteam_id');
            $table->decimal('point_spread',4,1)->nullable();
            $table->integer('favoriteteam_id')->nullable();
            $table->integer('hometeam_pts')->nullable();
            $table->integer('awayteam_pts')->nullable();
            $table->integer('default_game')->nullable();
            $table->dateTime('gamedate');
            $table->boolean('noline')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
