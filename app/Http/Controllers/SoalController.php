<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\Proyek;
use App\Models\TmpFile;
use App\Models\TipeSoal;
use App\Models\SoalDetail;
use App\Models\UjianSiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Soal::orderBy('id', 'desc')
            ->where('created_by', auth()->user()->id)
            ->where('is_deleted', false)
            ->get();
        return view('pages.teacher.soal.index', compact('data'));
    }

    public function copySoal($id)
    {
        $soal = Soal::findOrFail($id);
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
        return redirect()->route('soal.index')->with('success', 'Soal berhasil di copy');
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
        $data['hide_sidebar'] = true;
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
        // dd($request->all());

        try {

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

                $kunci_jawaban = $request->input($i.'_kunci_jawaban');

                // soal pilihan ganda
                if ($request->tipe_soal_id[$key] == '1') {
                    $opsi_jawaban = $request->input($i.'_opsi_jawaban');
                }

                // soal tipe mencocokan
                if ($request->tipe_soal_id[$key] == '2') {
                    $opsi_jawaban_kiri = $request->input($i.'_opsi_jawaban_kiri');
                    $opsi_jawaban_kanan = $request->input($i.'_opsi_jawaban_kanan');
                    $opsi_jawaban = [
                        'judul' => [
                            'kiri' => $request->input($i.'_judul_kiri'),
                            'kanan' => $request->input($i.'_judul_kanan'),
                        ],
                        'opsi_jawaban_kiri' => $opsi_jawaban_kiri,
                        'opsi_jawaban_kanan' => $opsi_jawaban_kanan,
                    ];
                }

                // soal tipe benar salah
                if ($request->tipe_soal_id[$key] == '3') {
                    $opsi_jawaban = [
                        'judul' => $request->input($i.'_judul'),
                        'opsi' => $request->input($i.'_opsi_jawaban'),
                    ];
                }

                //soal tipe essay || isian singkat
                if ($request->tipe_soal_id[$key] == '5' || $request->tipe_soal_id[$key] == '4') {
                    $kunci_jawaban = $request->input($i.'_opsi_jawaban');
                }

                SoalDetail::create([
                    'soal_id' => $soal->id,
                    'tipe_soal_id' => $request->tipe_soal_id[$key],
                    'pertanyaan' => $pertanyaan,
                    'stimulus' => $stimulusArray,
                    'opsi_jawaban' => $opsi_jawaban,
                    'kunci_jawaban' => $kunci_jawaban,
                    'skor' => $request->skor[$key],
                    'feedback' => $request->feedback[$key],
                ]);
            }
            
            // Move file from dir tmp -> uploads
            \App\Helpers\_tmpFile::moveFile($stimulusDokumen);

        } catch (\Throwable $th) {

            dd($th->getMessage());
            return back()->with('error', $th->getMessage());
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
        ]);
        return redirect()->route('soal.index', ['proyek'=>$soal->proyek_id])->with('success', 'Data berhasil disimpan');
    }

    public function preview($id)
    {
        $data['soal'] = Soal::find($id);
        $data['ujian'] = false;
        $data['pernyataan'] = [];
        if ($data['soal']->SoalDetail->count() > 0) {
            return view('pages.ujian.soal')->with($data);
        }
        return 'soal kosong';
    }

    public function previewNilai(Request $request, $id)
    {
        $soal = Soal::find($id);
        $skor = [];
        $jawabanUser = []; 
        try {
            foreach ($soal->SoalDetail as $index => $item) {
                $jawabanUser[] = $request->input('no_'.$index + 1);

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
                

                // if ($item->kunci_jawaban[0] == $request->input('no_'.$index + 1)) {
                //     $benar += 1;
                //     $skor[] = $item->skor;
                //     $totalSkor += $item->skor;
                // } else if($item->tipe_soal_id == '2') {
                //     // soal mencocokan
                //     $opsi_kiri = $request->input('no_'.($index + 1).'_kiri');
                //     $opsi_kanan = $request->input('no_'.($index + 1).'_kanan');
                //     $jawabanUser[$index] = [$opsi_kiri, $opsi_kanan];
                //     if (in_array($opsi_kiri, $item->kunci_jawaban) && in_array($opsi_kanan, $item->kunci_jawaban)) {
                //         $benar += 1;
                //         $skor[] = $item->skor;
                //         $totalSkor += $item->skor;
                //     } else {
                //         $skor[] = 0;
                //     }
                // } else if($item->tipe_soal_id == '4') {
                //     // soal isian singkat
                //     if ($item->kunci_jawaban == $request->input('no_'.$index + 1)) {
                //         $benar += 1;
                //         $skor[] = $item->skor;
                //         $totalSkor += $item->skor;
                //     } else {
                //         $skor[] = 0;
                //     }
                // } else {
                //     $skor[] = 0;
                // }
            }
            $data = [
                'soal' => $soal->nama,
                'nilai' => $skor,
            ];
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return view('pages.ujian.nilai', ['data' => $data]);
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
            'token' => $request->is_mandiri == false ? $soal->id . Str::random(5) . date('Y', strtotime($soal->created_at)) : null,
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
