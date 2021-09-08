<?php

use Illuminate\Database\Seeder;
use App\Team;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('teams')->truncate();

        Team::create(['name' => 'Ravens','abbrev'=>'BAL','city'=>'Baltimore','division'=>'North','conference'=>'AFC','gif'=>'bal.gif']);
        Team::create(['name' => 'Bengals','abbrev'=>'CIN','city'=>'Cincinnati','division'=>'North','conference'=>'AFC','gif'=>'cin.gif']);
        Team::create(['name' => 'Browns','abbrev'=>'CLE','city'=>'Cleveland','division'=>'North','conference'=>'AFC','gif'=>'cle.gif']);
        Team::create(['name' => 'Steelers','abbrev'=>'PIT','city'=>'Pittsburgh','division'=>'North','conference'=>'AFC','gif'=>'pit.gif']);
        Team::create(['name' => 'Texans','abbrev'=>'HOU','city'=>'Houston','division'=>'South','conference'=>'AFC','gif'=>'hou.gif']);
        Team::create(['name' => 'Colts','abbrev'=>'IND','city'=>'Indianapolis','division'=>'South','conference'=>'AFC','gif'=>'ind.gif']);
        Team::create(['name' => 'Jaguars','abbrev'=>'JAX','city'=>'Jacksonville','division'=>'South','conference'=>'AFC','gif'=>'jax.gif']);
        Team::create(['name' => 'Titans','abbrev'=>'TEN','city'=>'Tennessee','division'=>'South','conference'=>'AFC','gif'=>'ten.gif']);
        Team::create(['name' => 'Bills','abbrev'=>'BUF','city'=>'Buffalo','division'=>'East','conference'=>'AFC','gif'=>'buf.gif']);
        Team::create(['name' => 'Dolphins','abbrev'=>'MIA','city'=>'Miami','division'=>'East','conference'=>'AFC','gif'=>'mia.gif']);
        Team::create(['name' => 'Patriots','abbrev'=>'NE','city'=>'New England','division'=>'East','conference'=>'AFC','gif'=>'ne.gif']);
        Team::create(['name' => 'Jets','abbrev'=>'NYJ','city'=>'New York','division'=>'East','conference'=>'AFC','gif'=>'nyj.gif']);
        Team::create(['name' => 'Broncos','abbrev'=>'DEN','city'=>'Denver','division'=>'West','conference'=>'AFC','gif'=>'den.gif']);
        Team::create(['name' => 'Chiefs','abbrev'=>'KC','city'=>'Kansas City','division'=>'West','conference'=>'AFC','gif'=>'kc.gif']);
        Team::create(['name' => 'Chargers','abbrev'=>'LAC','city'=>'Los Angeles','division'=>'West','conference'=>'AFC','gif'=>'sd.gif']);
        Team::create(['name' => 'Raiders','abbrev'=>'LV','city'=>'Las Vegas','division'=>'West','conference'=>'AFC','gif'=>'oak.gif']);
        Team::create(['name' => 'Bears','abbrev'=>'CHI','city'=>'Chicago','division'=>'North','conference'=>'NFC','gif'=>'chi.gif']);
        Team::create(['name' => 'Lions','abbrev'=>'DET','city'=>'Detroit','division'=>'North','conference'=>'NFC','gif'=>'det.gif']);
        Team::create(['name' => 'Packers','abbrev'=>'GB','city'=>'Green Bay','division'=>'North','conference'=>'NFC','gif'=>'gb.gif']);
        Team::create(['name' => 'Vikings','abbrev'=>'MIN','city'=>'Minnesota','division'=>'North','conference'=>'NFC','gif'=>'min.gif']);
        Team::create(['name' => 'Falcons','abbrev'=>'ATL','city'=>'Atlanta','division'=>'South','conference'=>'NFC','gif'=>'atl.gif']);
        Team::create(['name' => 'Panthers','abbrev'=>'CAR','city'=>'Carolina','division'=>'South','conference'=>'NFC','gif'=>'car.gif']);
        Team::create(['name' => 'Saints','abbrev'=>'NO','city'=>'New Orleans','division'=>'South','conference'=>'NFC','gif'=>'no.gif']);
        Team::create(['name' => 'Buccaneers','abbrev'=>'TB','city'=>'Tampa Bay','division'=>'South','conference'=>'NFC','gif'=>'tb.gif']);
        Team::create(['name' => 'Cowboys','abbrev'=>'DAL','city'=>'Dallas','division'=>'East','conference'=>'NFC','gif'=>'dal.gif']);
        Team::create(['name' => 'Giants','abbrev'=>'NYG','city'=>'New York','division'=>'East','conference'=>'NFC','gif'=>'nyg.gif']);
        Team::create(['name' => 'Eagles','abbrev'=>'PHI','city'=>'Philadelphia','division'=>'East','conference'=>'NFC','gif'=>'phi.gif']);
        Team::create(['name' => 'Washington','abbrev'=>'WAS','city'=>'Washington','division'=>'East','conference'=>'NFC','gif'=>'was.gif']);
        Team::create(['name' => 'Cardinals','abbrev'=>'ARI','city'=>'Arizona','division'=>'West','conference'=>'NFC','gif'=>'arz.gif']);
        Team::create(['name' => 'Rams','abbrev'=>'LAR','city'=>'Los Angeles','division'=>'West','conference'=>'NFC','gif'=>'stl.gif']);
        Team::create(['name' => '49ers','abbrev'=>'SF','city'=>'San Francisco','division'=>'West','conference'=>'NFC','gif'=>'sf.gif']);
        Team::create(['name' => 'Seahawks','abbrev'=>'SEA','city'=>'Seattle','division'=>'North','conference'=>'NFC','gif'=>'sea.gif']);

    }
}
