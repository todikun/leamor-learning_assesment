<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'Jhon Doe',
                'username' => 'jhon',
                'role' => 'teacher',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()
            ],
            [
                'nama' => 'Anne Doe',
                'username' => 'anne',
                'role' => 'teacher',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()
            ],
            [
                'nama' => 'Rick Doe',
                'username' => 'rick',
                'role' => 'teacher',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()
            ],
            [
                'nama' => 'Budi',
                'username' => 'budi',
                'role' => 'student',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()
            ],
            [
                'nama' => 'Putri',
                'username' => 'putri',
                'role' => 'student',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()
            ],
        ];
        User::insert($data);
    }
}
