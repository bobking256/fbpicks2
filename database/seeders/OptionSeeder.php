<?php

use Illuminate\Database\Seeder;
use App\Option;
use Illuminate\Support\Facades\DB;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('options')->truncate();

        Option::create(['message' => '','lockoption'=>0, 'lock'=>0]);
        Option::create(['message' => 'Welcome to the pool.','lockoption'=>1, 'lock'=>1]);
        Option::create(['message' => 'Welcome to the 2020 pool.','lockoption'=>0, 'lock'=>0]);
    }
}
