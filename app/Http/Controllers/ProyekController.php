<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Proyek;
use App\Models\SoalDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Soal::orderBy('id', 'desc')->where(function($q){
            $q->where('is_share', true);
            $q->where('is_deleted', false);
        })->get();
        return view('pages.teacher.proyek.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.teacher.proyek.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'is_share' => 'required',
        ]);

        Proyek::create([
            'nama' => $request->nama,
            'is_share' => $request->is_share,
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->route('proyek.index')->with('success', 'Data berhasil disimpan');
    }

    public function myProyek()
    {   
        $data = Soal::orderBy('id', 'desc')->where(function($q){
            if (auth()->user()->role == 'teacher') {
                $q->where('created_by', auth()->user()->id);
            }
            $q->where('is_deleted', false);
        })->get();
        return view('pages.teacher.proyek.my-proyek', compact('data'));
    }


    public function myProyekDelete()
    {   
        $data = Soal::where('created_by', auth()->user()->id)
                        ->where('is_deleted', true)
                        ->get();
        return view('pages.teacher.proyek.my-proyek-deleted', compact('data'));
    }

    public function copyProyek($id)
    {
        $soal = Soal::findOrFail($id);
        if ($soal->created_by == auth()->user()->id) {
            return redirect()->route('proyek.index')->with('error', 'Proyek sudah ada');
        } 

        $data = Soal::create([
            'pernyataan'=>$soal->pernyataan,
            'nama'=>$soal->nama.'_copy',
            'waktu_ujian'=>$soal->waktu_ujian,
            'cover'=>$soal->cover,
            'batch' => $soal->batch.'_copy',
            'is_share' => $soal->is_share,
            'waktu_akses_ujian' => $soal->waktu_akses_ujian,
            'is_mandiri' => $soal->is_mandiri,
            'created_by' => auth()->user()->id,
        ]);
        $data->update([
            'token' => $data->is_mandiri == false ? $data->id . Str::random(5) . date('Y', strtotime($data->created_at)) : null,
        ]);
           
        $soal_detail = SoalDetail::where('soal_id', $soal->id)->get();
        foreach ($soal_detail as $item) {
            SoalDetail::create([
                'soal_id' => $data->id,
                'tipe_soal_id' => $item->tipe_soal_id,
                'pertanyaan' => $item->pertanyaan,
                'stimulus' => $item->stimulus,
                'opsi_jawaban' => $item->opsi_jawaban,
                'kunci_jawaban' => $item->kunci_jawaban,
                'skor' => $item->skor,
                'feedback' => $item->feedback,
            ]);
        }
        return redirect()->route('proyek.index')->with('success', 'Data berhasil disimpan');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function show(Proyek $proyek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyek $proyek)
    {
        return view('pages.teacher.proyek.edit', ['data'=>$proyek]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyek $proyek)
    {
        $request->validate([
            'nama' => 'required',
            'is_share' => 'required',
        ]);

        $proyek->update([
            'nama' => $request->nama,
            'is_share' => $request->is_share,
        ]);
        return redirect()->route('proyek.my')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyek $proyek)
    {
        //
    }

    public function undo($id)
    {
        $data = Soal::find($id);
        $data->update([
            'is_deleted' => true
        ]);
        return redirect()->route('proyek.my')->with('success', 'Data berhasil dihapus');
    }

    public function redo($id)
    {
        $data = Soal::find($id);
        $data->update([
            'is_deleted' => false
        ]);
        return redirect()->route('proyek.deleted')->with('success', 'Data berhasil disimpan');
    }

    public function siswa()
    {
        $data = Soal::where('is_mandiri', true)->get();  
        return view('pages.student.ayo_tes', compact('data'));
    }
}
