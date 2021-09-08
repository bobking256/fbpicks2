<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPicksToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->boolean('pick531')->default(0);
            $table->boolean('pickall')->default(0);
            $table->boolean('active')->default(1);
            $table->boolean('admin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('pick531');
            $table->dropColumn('pickall');
            $table->dropColumn('active');
            $table->dropColumn('admin');
        });
    }
}
