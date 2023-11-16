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
                'price'         => '40000',
            ],[
                'template_name' => 'BlueFlower',
                'user_id'       => '3',
                'thumbnail'     => 'template2.webp',
                'price'         => '45000'
            ],[
                'template_name' => 'Monovita',
                'user_id'       => '3',
                'thumbnail'     => 'template3.webp',
                'price'         => '50000'
            ],[
                'template_name' => 'LuxuryVita',
                'user_id'       => '3',
                'thumbnail'     => 'template4.webp',
                'price'         => '45000'
            ],
        ]);
    }
}
