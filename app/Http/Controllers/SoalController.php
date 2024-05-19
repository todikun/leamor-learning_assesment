<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\Proyek;
use App\Models\TmpFile;
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
        $data = Soal::where('created_by', auth()->user()->id)->get();
        return view('pages.teacher.soal.index', compact('data'));
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
            'batch'=>'required',
        ]);

        $cover = \App\Helpers\_File::uploadFile($request->file('cover'));
        $soal = Soal::create([
            'pernyataan'=>$request->pernyataan,
            'nama'=>$request->nama,
            'waktu_ujian'=>$request->waktu_ujian,
            'batch'=>$request->batch,
            'cover'=>$cover,
            'is_share'=>$request->is_share,
            'created_by' => auth()->user()->id,
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

    public function tmpFile(Request $request)
    {
        try {
            $file = \App\Helpers\_tmpFile::uploadFile($request->tmp);
            $data = TmpFile::create([
                'name' => $file
            ]);
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th
            ], 400);
        }
    }

    public function createOrUpdateSoal(Request $request)
    {
        $soal = Soal::find($request->soal_id);
        $soalDetail = SoalDetail::where('soal_id', $soal->id);
        if ($soalDetail->exists()) {
            $soalDetail->delete();
        }
        $stimulusDokumen = array();
        foreach ($request->pertanyaan as $key => $pertanyaan) {
            $stimulusArray = array();
            $i = $key + 1;
            $index = 0;
            $stimulusTipe = $request->input($i.'_stimulus_tipe');
            $stimulus = $request->input($i.'_stimulus');

            // dd($stimulusTipe, $stimulus);
            foreach ($stimulusTipe as $tipe) {
                array_push($stimulusArray, [
                    'tipe' => $tipe,
                    'value' => $stimulus[$index]
                ]);
                if ($tipe == 'dokumen') {
                    array_push($stimulusDokumen, $stimulus[$index]);
                }
                $index++;
            }
            SoalDetail::create([
                'soal_id' => $soal->id,
                'tipe_soal_id' => $request->tipe_soal_id[$key],
                'pertanyaan' => $pertanyaan,
                'stimulus' => $stimulusArray,
                'opsi_jawaban' => $request->input($i.'_opsi_jawaban'),
                'kunci_jawaban' => $request->input($i.'_kunci_jawaban.0'),
                'skor' => $request->skor[$key],
                'feedback' => $request->feedback[$key],
            ]);
        }
        
        // Move file from dir tmp -> uploads
        \App\Helpers\_tmpFile::moveFile($stimulusDokumen);
        return view('pages.teacher.soal.open-akses', compact('soal'));
    }

    public function openAksesStore(Request $request)
    {
        $soal = Soal::find($request->soal_id);
        $soal->update([
            'is_mandiri' => $request->is_mandiri,
            'waktu_akses_ujian' => $request->is_mandiri == false ? $request->tanggal_ujian.' '.$request->jam_ujian.':00' : null,
            'token' => $request->is_mandiri == false ? $request->token : null,
        ]);
        return redirect()->route('soal.index', ['proyek'=>$soal->proyek_id])->with('success', 'Data berhasil disimpan');
    }

    public function preview($id)
    {
        $data['soal'] = Soal::find($id);
        if ($data['soal']->SoalDetail->count() > 0) {
            return view('pages.ujian.preview')->with($data);
        }
        return 'soal kosong';
    }

    public function nilai(Request $request, $id)
    {
        $soal = Soal::find($id);
        $benar = 0;
        $skor = 0;
        foreach ($soal->SoalDetail as $index => $item) {
            if ($item->kunci_jawaban == $request->input('no_'.$index + 1)) {
                $benar += 1;
                $skor += $item->skor;
            }
        }
        dd('benar '.$benar, 'skore ' . $skor);
    }

    public function listUsers($id)
    {
        $data = Soal::with(['UjianSiswa'])->has('UjianSiswa')->find($id);
        // dd($data);
        return view('pages.teacher.soal.users', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $soal = Soal::find($id);
        return view('pages.teacher.soal.edit', compact('soal'));
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
        $request->validate([
            'nama'=>'required',
            'waktu_ujian'=>'required',
            'batch'=>'required',
        ]);

        $soal = Soal::find($id);
        $cover = $request->cover ? \App\Helpers\_File::uploadFile($request->file('cover')) : $soal->cover;
        $soal->update([
            'pernyataan'=>$request->pernyataan,
            'nama'=>$request->nama,
            'waktu_ujian'=>$request->waktu_ujian,
            'batch'=>$request->batch,
            'cover'=>$cover,
            'is_mandiri' => $request->is_mandiri,
            'waktu_akses_ujian' => $request->is_mandiri == false ? $request->tanggal_ujian.' '.$request->jam_ujian.':00' : null,
        ]);

        return redirect()->route('soal.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $soal = Soal::find($id);
        $proyekId = $soal->proyek_id;
        $soal->delete();
        return redirect()->route('soal.index', ['proyek'=>$proyekId])->with('success', 'Data berhasil dihapus');
    }
}
