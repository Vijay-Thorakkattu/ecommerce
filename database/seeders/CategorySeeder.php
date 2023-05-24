<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Television',
            'created_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'name' => 'Headphones',
            'created_at' => Carbon::now(),

        ]);

        DB::table('categories')->insert([
            'name' => 'Mobile',
            'created_at' => Carbon::now(),

        ]);

        
    }


}
