<?php

namespace Database\Seeders;

use App\Models\TipeSoal;
use Illuminate\Database\Seeder;

class TipeSoalTableSeeder extends Seeder
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
                'nama' => 'Pilihan Ganda',
            ],
            [
                'nama' => 'Mencocokkan',
            ],
            [
                'nama' => 'Benar Salah',
            ],
            // [
            //     'nama' => 'Isian Singkat',
            // ],
            // [
            //     'nama' => 'Essay',
            // ],
        ];
        TipeSoal::insert($data);
    }
}
