<?php

use Illuminate\Database\Seeder;
use App\Group;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('groups')->truncate();

        Group::create(['name' => 'Admin']);
        Group::create(['name' => 'User']);

    }
}
