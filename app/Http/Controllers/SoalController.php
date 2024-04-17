<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\Proyek;
use App\Models\TipeSoal;
use App\Models\SoalDetail;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyek = Proyek::find(request('proyek'));
        $data = Soal::where('proyek_id', $proyek->id)->get();
        return view('pages.teacher.soal.index', compact('data', 'proyek'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proyek = Proyek::find(request('proyek'));
        return view('pages.teacher.soal.create', compact('proyek'));
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
            'nama'=>'required',
            'waktu_ujian'=>'required',
            'waktu_feedback'=>'required',
        ]);

        $cover = \App\Helpers\_File::uploadFile($request->file('cover'));
        $soal = Soal::create([
            'proyek_id'=>$request->proyek_id,
            'pernyataan'=>$request->pernyataan,
            'nama'=>$request->nama,
            'waktu_ujian'=>$request->waktu_ujian,
            'waktu_feedback'=>$request->waktu_feedback,
            'cover'=>$cover,
        ]);
        return redirect()->route('soal.show', $soal->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['soal'] = Soal::find($id);
        $data['detailSoal'] = SoalDetail::where('soal_id', $id)->get();
        $data['tipeSoal'] = TipeSoal::get();
        return view('pages.teacher.soal.create_or_update')->with($data);
    }

    public function createOrUpdateSoal(Request $request)
    {
        $soal = Soal::find($request->soal_id);
        $soalDetail = SoalDetail::where('soal_id', $soal->id);
        if ($soalDetail->exists()) {
            $soalDetail->delete();
        }
        foreach ($request->pertanyaan as $key => $pertanyaan) {
            $stimulusArray = array();
            $i = $key + 1;
            $indexTeks = 0;
            $indexDokumen = 0;
            $stimulusTipe = $request->input($i.'_stimulus_tipe');
            foreach ($stimulusTipe as $t => $tipe) {
                $res = '';
                if ($tipe == 'dokumen') {
                    $res = \App\Helpers\_File::uploadFile($request->file($i.'_stimulus')[$indexDokumen]);
                    $indexDokumen++;
                }
                if ($tipe == 'teks') {
                    $res = $request->input($i.'_stimulus')[$indexTeks];
                    $indexTeks++;
                }
                array_push($stimulusArray, [
                    'tipe' => $stimulusTipe[$t],
                    'value' => $res
                ]);
            }
            SoalDetail::create([
                'soal_id' => $soal->id,
                'tipe_soal_id' => $request->tipe_soal_id[$key],
                'pertanyaan' => $pertanyaan,
                'stimulus' => $stimulusArray,
                'opsi_jawaban' => $request->input($i.'_opsi_jawaban'),
                'kunci_jawaban' => $request->input($i.'_kunci_jawaban.0'),
                'skor' => $request->skor[$key],
            ]);
        }
        return view('pages.teacher.soal.open-akses', compact('soal'));
    }

    public function openAksesStore(Request $request)
    {
        $soal = Soal::find($request->soal_id);
        $soal->update([
            'is_mandiri' => $request->is_mandiri,
            'waktu_akses_ujian' => $request->is_mandiri == false ? $request->tanggal_ujian.' '.$request->jam_ujian.':00' : null,
            'token' => $request->is_mandiri == false ? $request->token : null,
            'token_expired' => $request->is_mandiri == false ? Carbon::now() : null,
        ]);
        return redirect()->route('soal.index', ['proyek'=>$soal->proyek_id])->with('success', 'Data berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
