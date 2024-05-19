<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\UjianSiswa;
use Illuminate\Http\Request;

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
    }

    public function detail($id)
    {
        $data = Soal::with(['UjianSiswa' => function($q){
            $q->orderBy('nilai', 'desc');
        }])->has('UjianSiswa')->find($id);
        return view('pages.teacher.rapor.detail', compact('data'));
    }

    public function ujian($id)
    {
        $data = UjianSiswa::with(['Soal', 'Siswa'])->has('Soal')->find($id);
        return view('pages.teacher.rapor.file_ujian', compact('data'));
    }
}
