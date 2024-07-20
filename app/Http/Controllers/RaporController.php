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
        if ($role == 'admin') {
            $data = Soal::get();
            return view('pages.teacher.rapor.index', compact('data'));
        }

        if ($role == 'teacher') {
            $data = Soal::where('created_by', auth()->user()->id)
                            // ->where('is_deleted', false)
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
        $param = request('sort');
        $role = auth()->user()->role;
        if (in_array($role, ['teacher', 'admin'])) {
            $data = Soal::with(['UjianSiswa' => function($q) use($param) {
                $q->orderBy('total_nilai', 'desc');
            }])->find($id);
            
            if ($param == 'nama') {
                $data->UjianSiswa = $data->UjianSiswa
                                        ->each(function($item, $index) {
                                            // tambah field rank
                                            $item->rank = $index + 1;
                                        })->sortBy(function($item) {
                                            // urutkan berdasarkan nama
                                            return $item->Siswa->nama;
                                        })->values(); 
            }

            return view('pages.teacher.rapor.detail', compact('data'));
        }
        
        if ($role == 'student') {
            $data = UjianSiswa::where('soal_id', $id)->where('user_id',auth()->user()->id)->get();
            return view('pages.student.rapor.detail', compact('data'));
        }
    }

    public function rank($soalId, $idUjian)
    {
        $data = UjianSiswa::orderBy('total_nilai', 'desc')->where('soal_id', $soalId)->get();
        // dd($data->where('id',$idUjian)->first()->Soal->SoalDetail);
        $rank = 1;
        foreach ($data as $item) {
            if ($item->id == $idUjian) {
                break;
            }
            $rank++;
        }
        $data = UjianSiswa::orderBy('total_nilai', 'desc')->where('soal_id', $soalId)->get();
       
        // dd($data->where('id',$idUjian)->first(), $data);
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
        $data = UjianSiswa::find($id);
        $feedback = $data->feedback;
        $feedback[$request->no_soal] = $request->feedback;
        $data->update([
            'feedback' => $feedback,
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

    public function exportPdfPermateri($id)
    {
        $data = UjianSiswa::with(['Soal', 'Siswa'])->find($id);
        $dataRank = UjianSiswa::orderBy('total_nilai', 'desc')->where('soal_id', $data->soal_id)->get();
        // dd($data->where('id',$idUjian)->first()->Soal->SoalDetail);
        $rank = 1;
        foreach ($dataRank as $item) {
            if ($item->id == $data->id) {
                break;
            }
            $rank++;
        }
        return view('pages.student.rapor.cetak', compact('data', 'rank'));
    }

}
