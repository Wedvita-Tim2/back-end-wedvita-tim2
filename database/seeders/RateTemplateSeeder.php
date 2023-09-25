<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RateTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rate_templates')->truncate();
        DB::table('rate_templates')->insert([
            [
                'template_id' => '1',
                'user_id'     => '4',
                'comment'     => 'Keren banget hasilnya!',
                'rating'      => '0.90',
                'rate_status' => 'show',
            ],[
                'template_id' => '1',
                'user_id'     => '5',
                'comment'     => 'Suka deh sama hasilnya!',
                'rating'      => '0.83',
                'rate_status' => 'show',
            ],[
                'template_id' => '1',
                'user_id'     => '6',
                'comment'     => 'Desain nya bagus, worth it sama harganya',
                'rating'      => '0.80',
                'rate_status' => 'show',
            ],[
                'template_id' => '2',
                'user_id'     => '4',
                'comment'     => 'Desainnya cukup bagus. Oke lah',
                'rating'      => '0.75',
                'rate_status' => 'show',
            ],[
                'template_id' => '2',
                'user_id'     => '5',
                'comment'     => 'Desainnnya bagus, temanya juga bagus',
                'rating'      => '0.70',
                'rate_status' => 'show',
            ],[
                'template_id' => '2',
                'user_id'     => '6',
                'comment'     => 'Cukup memuaskan',
                'rating'      => '0.70',
                'rate_status' => 'show',
            ],[
                'template_id' => '3',
                'user_id'     => '4',
                'comment'     => 'Wow, aku suka banget sama desainnya!',
                'rating'      => '0.90',
                'rate_status' => 'show',
            ],[
                'template_id' => '3',
                'user_id'     => '5',
                'comment'     => 'Suka banget sama hasilnya, terutama sama tata letak foto-fotonya, recommended banget, deh!',
                'rating'      => '1',
                'rate_status' => 'show',
            ],[
                'template_id' => '3',
                'user_id'     => '6',
                'comment'     => 'Harus banget pake desain yang ini. Sangat memuaskan',
                'rating'      => '0.97',
                'rate_status' => 'show',
            ],
        ]);
    }
}
