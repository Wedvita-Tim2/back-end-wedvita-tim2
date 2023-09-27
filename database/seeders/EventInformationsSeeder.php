<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventInformationsSeeder extends Seeder{

    public function run(): void{
        DB::table('event_informations')->truncate();
        DB::table('event_informations')->insert([
            [
                'bride_name' => 'Linda Johnson',
                'groom_name' => 'John Smith',
                'bride_mother_name' => 'Mary Anderson',
                'bride_father_name' => 'David Johnson',
                'groom_mother_name' => 'Susan Wilson',
                'groom_father_name' => 'Michael Smith',
                'cover_image' => 'nama_file_gambar.jpg',
                'date_event' => '2023-10-15',
                'address' => '123 Main Street, Cityville',
                'building_name' => 'Cityville Events Center',
                'guests' => 150,
                'account_number' => '1234567890'
            ],
            [
                'bride_name' => 'Sarah Davis',
                'groom_name' => 'Robert Brown',
                'bride_mother_name' => 'Jennifer Davis',
                'bride_father_name' => 'William Davis',
                'groom_mother_name' => 'Karen Brown',
                'groom_father_name' => 'Richard Brown',
                'cover_image' => 'nama_file_gambar2.jpg',
                'date_event' => '2023-11-20',
                'address' => '456 Elm Street, Townsville',
                'building_name' => 'Townsville Banquet Hall',
                'guests' => 200,
                'account_number' => '9876543210' 
            ],
            [
                'bride_name' => 'Jessica White',
                'groom_name' => 'Daniel Clark',
                'bride_mother_name' => 'Karen White',
                'bride_father_name' => 'John White',
                'groom_mother_name' => 'Deborah Clark',
                'groom_father_name' => 'Steven Clark',
                'cover_image' => 'nama_file_gambar3.jpg',
                'date_event' => '2024-02-12',
                'address' => '789 Oak Avenue, Villagetown',
                'building_name' => 'Villagetown Manor',
                'guests' => 180,
                'account_number' => '5555555555'
            ],
            [
                'bride_name' => 'Melissa Martinez',
                'groom_name' => 'Jose Rodriguez',
                'bride_mother_name' => 'Maria Martinez',
                'bride_father_name' => 'Carlos Martinez',
                'groom_mother_name' => 'Ana Rodriguez',
                'groom_father_name' => 'Luis Rodriguez',
                'cover_image' => 'nama_file_gambar4.jpg',
                'date_event' => '2024-04-30',
                'address' => '101 Pine Lane, Sunnyside',
                'building_name' => 'Sunnyside Community Center',
                'guests' => 220,
                'account_number' => '1111222233'
            ],
            [
                'bride_name' => 'Emily Wilson',
                'groom_name' => 'James Thompson',
                'bride_mother_name' => 'Laura Wilson',
                'bride_father_name' => 'Mark Wilson',
                'groom_mother_name' => 'Patricia Thompson',
                'groom_father_name' => 'Robert Thompson',
                'cover_image' => 'nama_file_gambar5.jpg',
                'date_event' => '2024-06-15',
                'address' => '222 Maple Street, Lakeside',
                'building_name' => 'Lakeside Grand Hotel',
                'guests' => 250,
                'account_number' => '9999888877'
            ],
            [
                'bride_name' => 'Rachel Anderson',
                'groom_name' => 'Thomas Baker',
                'bride_mother_name' => 'Susan Anderson',
                'bride_father_name' => 'Richard Anderson',
                'groom_mother_name' => 'Catherine Baker',
                'groom_father_name' => 'William Baker',
                'cover_image' => 'gambar_acara_6.jpg',
                'date_event' => '2024-08-10',
                'address' => '567 Oakwood Drive, Riverside',
                'building_name' => 'Riverside Gardens',
                'guests' => 180,
                'account_number' => '7777666677'
            ],
            [
                'bride_name' => 'Haley Turner',
                'groom_name' => 'Daniel Harris',
                'bride_mother_name' => 'Megan Turner',
                'bride_father_name' => 'Kevin Turner',
                'groom_mother_name' => 'Linda Harris',
                'groom_father_name' => 'Robert Harris',
                'cover_image' => 'gambar_acara_7.jpg',
                'date_event' => '2024-09-25',
                'address' => '321 Elm Street, Hillside',
                'building_name' => 'Hillside Community Center',
                'guests' => 200,
                'account_number' => '4444333322'
            ],
            [
                'bride_name' => 'Natalie Brown',
                'groom_name' => 'Jacob Davis',
                'bride_mother_name' => 'Julia Brown',
                'bride_father_name' => 'Steven Brown',
                'groom_mother_name' => 'Lisa Davis',
                'groom_father_name' => 'William Davis',
                'cover_image' => 'gambar_acara_8.jpg',
                'date_event' => '2024-11-05',
                'address' => '101 Sunset Drive, Westfield',
                'building_name' => 'Westfield Hall',
                'guests' => 150,
                'account_number' => '5555777888'
            ],
            [
                'bride_name' => 'Grace Wilson',
                'groom_name' => 'Benjamin Mitchell',
                'bride_mother_name' => 'Amy Wilson',
                'bride_father_name' => 'Daniel Wilson',
                'groom_mother_name' => 'Karen Mitchell',
                'groom_father_name' => 'James Mitchell',
                'cover_image' => 'gambar_acara_9.jpg',
                'date_event' => '2025-01-20',
                'address' => '789 Park Avenue, Green Valley',
                'building_name' => 'Green Valley Resort',
                'guests' => 220,
                'account_number' => '6666999911'
            ],
            [
                'bride_name' => 'Olivia King',
                'groom_name' => 'Ethan Young',
                'bride_mother_name' => 'Jennifer King',
                'bride_father_name' => 'David King',
                'groom_mother_name' => 'Laura Young',
                'groom_father_name' => 'Michael Young',
                'cover_image' => 'gambar_acara_10.jpg',
                'date_event' => '2025-03-15',
                'address' => '222 Maple Lane, Lakeside',
                'building_name' => 'Lakeside Grand Ballroom',
                'guests' => 250,
                'account_number' => '1234987654'
            ]
            ]);
    }
}