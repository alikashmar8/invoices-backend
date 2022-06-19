<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            'name' => 'Basic',
            'price' => 0, 
            'businesses_profiles' => 1,
            'number_docs' => 50,
            'team_members' => 1,
        ]);
        DB::table('plans')->insert([
            'name' => 'Gold',
            'price' => 59, 
            'businesses_profiles' => 1,
            'number_docs' => 500,
            'team_members' => 10,
        ]);
        DB::table('plans')->insert([
            'name' => 'Gem',
            'price' => 99, 
            'businesses_profiles' => -1,
            'number_docs' => -1,
            'team_members' => -1,
        ]);
        
    }
}
