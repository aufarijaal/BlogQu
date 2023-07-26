<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_path = resource_path('sql/whatever.sql');

        DB::unprepared(
            file_get_contents($file_path)
        );

        \App\Models\Post::factory(200)->create();
    }
}
