<?php

use Illuminate\Database\Seeder;
use App\Weekno;
use Illuminate\Support\Facades\DB;


class WeeknoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('weeknos')->truncate();

        Weekno::create(['weektime' => '2020-09-15 18:00:00','picktime'=>'2020-09-10 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-09-22 18:00:00','picktime'=>'2020-09-17 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-09-29 18:00:00','picktime'=>'2020-09-24 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-10-06 18:00:00','picktime'=>'2020-10-01 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-10-13 18:00:00','picktime'=>'2020-10-08 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-10-20 18:00:00','picktime'=>'2020-10-15 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-10-27 18:00:00','picktime'=>'2020-10-22 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-11-03 18:00:00','picktime'=>'2020-10-29 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-11-10 18:00:00','picktime'=>'2020-11-05 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-11-17 18:00:00','picktime'=>'2020-11-12 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-11-24 18:00:00','picktime'=>'2020-11-19 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-12-01 18:00:00','picktime'=>'2020-11-26 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-12-08 18:00:00','picktime'=>'2020-12-03 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-12-15 18:00:00','picktime'=>'2020-12-10 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-12-22 18:00:00','picktime'=>'2020-12-17 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2020-12-29 18:00:00','picktime'=>'2020-12-23 18:00:00','state'=>'0']);
        Weekno::create(['weektime' => '2021-01-09 18:00:00','picktime'=>'2021-01-02 18:00:00','state'=>'0']);

    }
}
