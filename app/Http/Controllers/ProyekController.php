<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Proyek;
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
        $data = Proyek::where('is_share', true)->where('is_deleted', false)->get();
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
        $data = Proyek::where('created_by', auth()->user()->id)
                        ->where('is_deleted', false)
                        ->get();
        return view('pages.teacher.proyek.my-proyek', compact('data'));
    }


    public function myProyekDelete()
    {   
        $data = Proyek::where('created_by', auth()->user()->id)
                        ->where('is_deleted', true)
                        ->get();
        return view('pages.teacher.proyek.my-proyek-deleted', compact('data'));
    }

    public function copyProyek($id)
    {
        $proyek = Proyek::findOrFail($id);
        if ($proyek->created_by == auth()->user()->id) {
            return redirect()->route('proyek.index')->with('error', 'Proyek sudah ada');
        } 
        $data = Proyek::create([
            'nama' => $proyek->nama . '_copy',
            'is_share' => $proyek->is_share,
            'created_by' => auth()->user()->id,
        ]);

        $soal = Soal::where('proyek_id', $proyek->id)->get();
        if ($soal) {
            foreach ($soal as $item) {
                Soal::create([
                    'proyek_id'=>$data->id,
                    'pernyataan'=>$item->pernyataan,
                    'nama'=>$item->nama,
                    'waktu_ujian'=>$item->waktu_ujian,
                    'waktu_feedback'=>$item->waktu_feedback,
                    'cover'=>$item->cover,
                ]);
            }
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
        $data = Proyek::find($id);
        $data->update([
            'is_deleted' => true
        ]);
        return redirect()->route('proyek.my')->with('success', 'Data berhasil dihapus');
    }

    public function redo($id)
    {
        $data = Proyek::find($id);
        $data->update([
            'is_deleted' => false
        ]);
        return redirect()->route('proyek.deleted')->with('success', 'Data berhasil disimpan');
    }
}
