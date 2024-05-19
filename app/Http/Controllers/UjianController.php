<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\UjianSiswa;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function ujianMandiri($id)
    {
        $soal = Soal::find($id);
        return view('pages.student.identitas', ['soal' => $soal, 'ujian' => true]);
    }

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
        $siswa = UjianSiswa::create([
            'soal_id' => $request->soal_id,
            'pernyataan' => $request->pernyataan,
            'user_id' => auth()->user()->id,
        ]);

        $soal = Soal::find($request->soal_id);

        return view('pages.student.soal', compact('soal', 'siswa'));
    }

    public function storeNilai(Request $request, $id)
    {
        $soal = Soal::find($id);
        $benar = 0;
        $skor = 0;
        $jawabanUser = []; 
        foreach ($soal->SoalDetail as $index => $item) {
            $jawabanUser[] = $request->input('no_'.$index + 1);
            if ($item->kunci_jawaban == $request->input('no_'.$index + 1)) {
                $benar += 1;
                $skor += $item->skor;
            }
        }

        $ujianSiswa = UjianSiswa::find($request->ujian_siswa_id);
        $ujianSiswa->update([
            'jawaban' => $jawabanUser,
            'nilai' => $skor,
        ]);
        
        return view('pages.student.nilai', ['data' => $ujianSiswa, 'ujian' => true]);
    }



    public function storeNilaiFeedback(Request $request, $id)
    {
        dd($id);
    }

}
