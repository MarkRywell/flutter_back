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
                'address' => 'Cagayan de Oro City',
                'email' => 'markgaje43@gmail.com',
                'password' => bcrypt('mark123')
            ],
            [
                'name' => 'Mark Bontia',
                'address' => 'Gingoog Misamis Oriental',
                'email' => 'markB@gmail.com',
                'password' => bcrypt('mark123')
            ],
            [
                'name' => 'John Ray Canete',
                'address' => 'General Santos City',
                'email' => 'janri@gmail.com',
                'password' => bcrypt('janri123')
            ],
        ];

        DB::table('users')->insert($users);
    }
}
