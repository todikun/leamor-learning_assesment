<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\UjianSiswa;
use Illuminate\Http\Request;
use App\Models\UjianSiswaFeedback;

class RaporController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        if ($role == 'teacher') {
            $data = Soal::where('created_by', auth()->user()->id)
                            ->where('is_deleted', false)
                            ->get();
            return view('pages.teacher.rapor.index', compact('data'));
        }

        if ($role == 'student') {
            $data = Soal::with(['UjianSiswa' => function($q){
                $q->where('user_id', auth()->user()->id);
            }])->has('UjianSiswa')->get()->filter(function($q){
                return $q->UjianSiswa->isNotEmpty();
            })->values();
            return view('pages.student.rapor.index', compact('data'));
        }
    }

    public function detail($id)
    {
        $role = auth()->user()->role;
        if ($role == 'teacher') {
            $data = Soal::with(['UjianSiswa' => function($q){
                $q->orderBy('total_nilai', 'desc');
            }])->find($id);
            // dd($data,$id);
            return view('pages.teacher.rapor.detail', compact('data'));
        }
        
        if ($role == 'student') {
            $data = UjianSiswa::where('soal_id', $id)->where('user_id',auth()->user()->id)->get();
            return view('pages.student.rapor.detail', compact('data'));
        }
    }

    public function rank($soalId, $idUjian)
    {
        $data = UjianSiswa::orderBy('nilai', 'desc')->where('soal_id', $soalId)->get();
        // dd($data->where('id',$idUjian)->first()->Soal->SoalDetail);
        $rank = 1;
        foreach ($data as $item) {
            if ($item->id == $idUjian) {
                break;
            }
            $rank++;
        }
        return view('pages.student.rapor.rank', [
            'data' =>$data->where('id',$idUjian)->first(),
            'rank' =>$rank,
        ]);
    }

    public function ujian($id)
    {
        $data = Soal::with(['UjianSiswa' => function($q){
            $q->orderBy('total_nilai', 'desc');
        }])->find($id);
        dd($data);
        return view('pages.teacher.rapor.file_ujian', compact('data'));
    }

    public function feedbackForm($id)
    {
        $data = UjianSiswa::find($id);
        return view('pages.teacher.rapor.feedback', compact('data'));
    }

    public function feedbackStore(Request $request, $id)
    {
        UjianSiswaFeedback::create([
            'ujian_siswa_id' => $id,
            'soal_detail_id' => $request->soal_detail_id,
            'feedback' => $request->feedback,
        ]);
        return back()->with('success', 'Feedback berhasil ditambahkan');
    }

    public function koreksiForm($id)
    {
        $data = UjianSiswa::find($id);
        return view('pages.teacher.rapor.koreksi', compact('data'));
    }

    public function koreksiStore(Request $request, $id)
    {
        $data = UjianSiswa::find($id);
        $nilai = $data->nilai;
        $nilai[$request->no_soal] = (int) $request->nilai;
        $data->update([
            'nilai' => $nilai,
            'total_nilai' => array_sum($nilai),
        ]);
        return back()->with('success', 'Koreksi Nilai berhasil disimpan');
    }
    
    public function submit($id)
    {
        $siswa = UjianSiswa::find($id);
        $siswa->update([
            'is_selesai' => true,
        ]);
        return back()->with('success', 'Rapor berhasil disubmit');
    }

    public function exportPdf($id)
    {
        $data = UjianSiswa::where('soal_id', $id)->orderBy('total_nilai', 'desc')->get();
        dd($data);
    }

}
