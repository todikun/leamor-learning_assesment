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
        return view('pages.student.identitas', compact('soal'));
    }

    public function cekAkses(Request $request)
    {
        $soal = Soal::whereToken($request->token)->first();
        if (!$soal) {
            return 'Kode akses tidak valid!';
        }

        $siswa = UjianSiswa::where('soal_id', $soal->id)->where('user_id', auth()->user()->id)->first();
        if ($siswa) {
            return 'Kamu sudah pernah mengikuti ujian ini!';
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

        return view('pages.student.identitas', compact('soal'));
    }

    public function ujianForm(Request $request)
    {
        $soal = Soal::find($request->soal_id);

        return view('pages.ujian.soal', ['soal' => $soal, 'pernyataan' => $request->pernyataan, 'ujian' => true]);
    }

    public function storeNilai(Request $request, $id)
    {
        $soal = Soal::find($id);
        $skor = [];
        $jawabanUser = []; 
        try {
            foreach ($soal->SoalDetail as $index => $item) {
                $jawabanUser[] = $request->input('no_'.$index + 1);
                $feedback[] = $request->feedback[$index] ?? $item->feedback;
                              
                // pilihan ganda
                if ($item->tipe_soal_id == '1') {
                    $tempBenar = 0;
                    foreach ($jawabanUser[$index] ?? [] as $jawaban) {
                        if (in_array($jawaban, $item->kunci_jawaban)) {
                            $tempBenar += 1;
                        }
                    }
                    $butir_kunci_jawaban = sizeof($item->kunci_jawaban);
                    $skor_per_butir = $item->skor / $butir_kunci_jawaban;
                    $skor[] = $tempBenar * $skor_per_butir;
                }

                // mencocokan / benar salah
                if ($item->tipe_soal_id == '2' || $item->tipe_soal_id == '3') {
                    $tempBenar = 0;
                    foreach ($jawabanUser[$index] ?? [] as $key => $jawaban) {
                        if ($jawaban == $item->kunci_jawaban[$key]) {
                            $tempBenar += 1;
                        }
                    }
                    $butir_kunci_jawaban = sizeof($item->kunci_jawaban);
                    $skor_per_butir = $item->skor / $butir_kunci_jawaban;
                    $skor[] = $tempBenar * $skor_per_butir;
                }

            }
    
            $ujianSiswa = UjianSiswa::create([
                'soal_id' => $soal->id,
                'pernyataan' => $request->pernyataan,
                'user_id' => auth()->user()->id,
                'jawaban' => $jawabanUser,
                'feedback' => $feedback,
                'nilai' => $skor,
                'total_nilai' => array_sum($skor),
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return view('pages.ujian.nilai', ['data' => $ujianSiswa]);
    }

}
