@extends('layouts.app')

@section('title', 'Identitas Siswa')

@section('content')
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card rounded">
                    <div class="card-body">
                        {{-- <h2 class="fw-bold text-center">Ujian {{$soal->Proyek->nama}}</h2> --}}
                        <p class="text-center">Topik <strong>{{$soal->nama}}</p>
                        <form action="{{route('ujian.form')}}" method="post">
                            @csrf

                            <input type="hidden" name="soal_id" value="{{$soal->id}}" />
                            <div class="row justify-content-center mt-3 mb-1">
                                @foreach ($soal->pernyataan as $item)
                                    <input type="text" name="pernyataan[]" class="form-control mb-3" placeholder="{{$item}}" required />
                                @endforeach
                                <button type="submit" class="form-control btn btn-success btn-lg mb-1">Mulai</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection