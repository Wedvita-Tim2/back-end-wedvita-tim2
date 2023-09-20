<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'role_id'               => '1',
                'username'              => 'daniar',
                'phone_number'          => '0812345678901',
                'email'                 => 'daniar@gmail.com',
                'password'              => bcrypt('@Daniar123'),
            ], [
                'role_id'               => '2',
                'username'              => 'alfien',
                'phone_number'          => '0812345678902',
                'email'                 => 'alfien@gmail.com',
                'password'              => bcrypt('@Alfien123'),
            ], [
                'role_id'               => '2',
                'username'              => 'fadel',
                'phone_number'          => '0812345678903',
                'email'                 => 'fadel@gmail.com',
                'password'              => bcrypt('@Fadel123'),
            ], [
                'role_id'               => '2',
                'username'              => 'arya',
                'phone_number'          => '0812345678904',
                'email'                 => 'arya@gmail.com',
                'password'              => bcrypt('@Arya123'),
            ], [
                'role_id'               => '2',
                'username'              => 'syira',
                'phone_number'          => '0812345678905',
                'email'                 => 'syira@gmail.com',
                'password'              => bcrypt('@Syira123'),
            ], [
                'role_id'               => '2',
                'username'              => 'afyar',
                'phone_number'          => '0812345678906',
                'email'                 => 'afyar@gmail.com',
                'password'              => bcrypt('@Afyar123'),
            ], 
        ]);
    }
}
