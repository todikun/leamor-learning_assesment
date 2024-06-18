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
        $siswa = UjianSiswa::create([
            'soal_id' => $request->soal_id,
            'pernyataan' => $request->pernyataan,
            'user_id' => auth()->user()->id,
        ]);

        $soal = Soal::find($request->soal_id);

        return view('pages.ujian.soal', ['soal' => $soal, 'siswa' => $siswa, 'ujian' => true]);
    }

    public function storeNilai(Request $request, $id)
    {
        $soal = Soal::find($id);
        $benar = 0;
        $skor = [];
        $totalSkor = 0;
        $jawabanUser = []; 
        try {
            foreach ($soal->SoalDetail as $index => $item) {
                $jawabanUser[] = $request->input('no_'.$index + 1);
                $feedback[] = $request->feedback[$index] ?? null;
    
                if ($item->kunci_jawaban[0] == $request->input('no_'.$index + 1)) {
                    $benar += 1;
                    $skor[] = $item->skor;
                    $totalSkor += $item->skor;
                } else if($item->tipe_soal_id == '2') {
                    // soal mencocokan
                    $opsi_kiri = $request->input('no_'.($index + 1).'_kiri');
                    $opsi_kanan = $request->input('no_'.($index + 1).'_kanan');
                    $jawabanUser[$index] = [$opsi_kiri, $opsi_kanan];
                    if (in_array($opsi_kiri, $item->kunci_jawaban) && in_array($opsi_kanan, $item->kunci_jawaban)) {
                        $benar += 1;
                        $skor[] = $item->skor;
                        $totalSkor += $item->skor;
                    } else {
                        $skor[] = 0;
                    }
                } else if($item->tipe_soal_id == '4') {
                    // soal isian singkat
                    if ($item->kunci_jawaban == $request->input('no_'.$index + 1)) {
                        $benar += 1;
                        $skor[] = $item->skor;
                        $totalSkor += $item->skor;
                    } else {
                        $skor[] = 0;
                    }
                } else {
                    $skor[] = 0;
                }
            }
    
            $ujianSiswa = UjianSiswa::find($request->ujian_siswa_id);
            $ujianSiswa->update([
                'jawaban' => $jawabanUser,
                'feedback' => $feedback,
                'nilai' => $skor,
                'total_nilai' => $totalSkor,
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return view('pages.ujian.nilai', ['data' => $ujianSiswa, 'ujian' => true]);
    }

}
