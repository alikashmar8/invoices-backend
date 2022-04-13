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
        ]);
        DB::table('plans')->insert([
            'name' => 'Pro',
            'price' => 49, 
        ]);
        DB::table('plans')->insert([
            'name' => 'Advanced',
            'price' => 99, 
        ]);
    }
}
