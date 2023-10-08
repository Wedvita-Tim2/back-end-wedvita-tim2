<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('templates')->truncate();
        DB::table('templates')->insert([
            [
                'template_name' => 'R&B',
                'user_id'       => '2',
                'thumbnail'     => 'img-4.webp',
            ],[
                'template_name' => 'TraditionalBali',
                'user_id'       => '3',
                'thumbnail'     => 'img-4.webp',
            ],[
                'template_name' => 'VintageMinimalist',
                'user_id'       => '3',
                'thumbnail'     => 'img-4.webp',
            ],
        ]);
    }
}
