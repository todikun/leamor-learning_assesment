<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function cekAkses(Request $request)
    {
        $soal = Soal::whereToken($request->token)->first();
        if (!$soal) {
            return 'Kode akses tidak valid!';
        }
        
        $waktuAksesUjian = strtotime($soal->waktu_akses_ujian);
        $waktuSekarang = strtotime(date('Y-m-d H:i:s'));
        $waktuAksesUjianFormat = date('d F Y H:i', $waktuAksesUjian);
        if ($waktuAksesUjian > $waktuSekarang) {
            return 'Ujian belum dimulai. Silahkan akses kembali pada ' . $waktuAksesUjianFormat;
        }

        $lamaAksesUjian = $waktuAksesUjian + ((int) $soal->waktu_ujian * 60);
        $lamaAksesUjianFormat = date('d F Y H:i', $lamaAksesUjian);
        if ($waktuSekarang > $lamaAksesUjian) {
            return 'Ujian sudah berakhir pada ' . $lamaAksesUjianFormat;
        }

        return view('pages.student.identitas', ['soal' => $soal, 'ujian' => true]);
    }

    public function ujianForm(Request $request)
    {
        $data = UjianSiswa::create([
            'soal_id' => $request->soal_id,
            'pernyataan' => $request->pernyataan
        ]);

        return view('pages.student.soal', compact('data'));
    }

    public function storeNilaiFeedback(Request $request, $id)
    {
        dd($id);
    }

}
