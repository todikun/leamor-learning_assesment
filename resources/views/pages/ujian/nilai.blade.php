@extends('layouts.app')

@section('title', 'Nilai Siswa')

@section('content')
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="mb-5">Topik <strong>{{$data->Soal->nama ?? $data['soal']}}</h5>
                        
                        <div class="col-md-12 mb-5">
                            <span>Hasil Tes</span>
                            <h2 class="">{{array_sum($data->nilai ?? $data['nilai'])}}</h2>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-center">
                                @if (auth()->user()->role == 'teacher')
                                <div class="col-md-5 ms-3">
                                    <a href="{{route('soal.index')}}" class="form-control btn btn-success">Menu Utama</a>      
                                </div>
                                @else
                                <div class="col-md-5 ms-3">
                                    <a href="{{route('ayo_tes')}}" class="form-control btn btn-success">Menu Utama</a>
                                </div>
                                <div class="col-md-5 ms-3">
                                    <a href="{{route('rapor.student.detail', $data->Soal->id)}}" class="form-control btn btn-primary">Rapor</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection