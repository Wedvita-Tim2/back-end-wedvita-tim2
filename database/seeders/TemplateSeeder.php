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
                'template_name' => 'Romantic Delight',
                'user_id'       => '2',
            ],[
                'template_name' => 'Traditional Bali',
                'user_id'       => '3',
            ],[
                'template_name' => 'Vintage Minimalist',
                'user_id'       => '3',
            ],
        ]);
    }
}
