<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Mark Gaje',
                'contactNo' => '09265567313',
                'address' => 'Cagayan de Oro City',
                'email' => 'markgaje43@gmail.com',
                'password' => bcrypt('mark123')
            ],
            [
                'name' => 'Mark Bontia',
                'contactNo' => '09001112222',
                'address' => 'Gingoog Misamis Oriental',
                'email' => 'markB@gmail.com',
                'password' => bcrypt('mark123')
            ],
            [
                'name' => 'John Ray Canete',
                'contactNo' => '09112223333',
                'address' => 'General Santos City',
                'email' => 'janri@gmail.com',
                'password' => bcrypt('janri123')
            ],
        ];

        DB::table('users')->insert($users);
    }
}
