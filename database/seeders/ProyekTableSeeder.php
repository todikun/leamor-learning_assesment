<?php

namespace Database\Seeders;

use App\Models\Proyek;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProyekTableSeeder extends Seeder
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
                'nama' => 'IPA',
                'created_by' => 1,
                'is_share' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'nama' => 'BIOLOGI',
                'created_by' => 1,
                'is_share' => 0,
                'created_at' => Carbon::now()
            ],
        ];
        Proyek::insert($data);
    }
}
