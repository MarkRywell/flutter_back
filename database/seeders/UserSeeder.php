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
                'password' => 'mark123'
            ]
        ];

        DB::table('users')->insert($users);
    }
}
