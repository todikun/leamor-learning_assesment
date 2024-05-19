@extends('layouts.app')

@section('title', 'Identitas Siswa')

@section('content')
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="mb-5">Topik <strong>{{$data->Soal->nama}}</h5>
                        
                        <div class="col-md-12 mb-5">
                            <span>Hasil Tes</span>
                            <h2 class="">{{$data->nilai}}</h2>
                        </div>

                        <div class="col-md-12">
                            <a href="{{route('ayo_tes')}}" class="form-control btn btn-success">Menu Utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection