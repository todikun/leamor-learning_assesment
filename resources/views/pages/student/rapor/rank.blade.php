@extends('layouts.app')

@section('title', 'Rapor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="h4">Rapor Ujian: {{$data->Soal->nama ?? '-'}} </h4>
    <h4 class="h4">{{$data->Siswa->nama}}, Peringkat: {{$rank}}, Total Skor: {{$data->total_nilai}}</h4>
    <a href="{{route('export.permateri', $data->id)}}" class="btn btn-danger">
        <i class="fa fa-file"></i> PDF
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="myTable" class="table">
                    <thead>
                        <tr class="text-center" style="background-color: #79dfc1;">
                            <th>No</th>
                            <th>Tipe Soal</th>
                            <th>Soal</th>
                            <th>Feedback</th>
                            <th>Kunci Jawaban</th>
                            <th>Jawaban Siswa</th>
                            <th>Koreksi</th>
                            <th>Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->Soal->SoalDetail as $key => $item)
                            <tr class="text-center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->TipeSoal->nama}}</td>
                                <td>{!!$item->pertanyaan!!}</td>
                                <td>
                                    <a href="{{route('rapor.teacher.feedback', [$data->id,'index'=>$key])}}" class="btn-feedback">Lihat feedback</a>
                                </td>

                                <td>
                                    @if (is_array($data->Soal->SoalDetail[$key]->kunci_jawaban))
                                        @foreach ($data->Soal->SoalDetail[$key]->kunci_jawaban as $j)
                                            {!!$j!!}, 
                                        @endforeach
                                    @else
                                        {!!$data->Soal->SoalDetail[$key]->kunci_jawaban!!}
                                    @endif
                                </td>

                                <td>
                                    @if (is_array($data->jawaban[$key]))
                                        @foreach ($data->jawaban[$key] as $j)
                                            {!!$j!!}, 
                                        @endforeach
                                    @else
                                        {!!$data->jawaban[$key]!!}
                                    @endif
                                </td>
                                <td>
                                    @php
                                        if ($data->nilai[$key] != '0' && $data->nilai[$key] == $data->Soal->SoalDetail[$key]->skor) {
                                            $color = 'success';
                                            $icon = 'check';
                                            $ctt = '';
                                        } else if ($data->nilai[$key] != '0') {
                                            $color = 'warning';
                                            $icon = 'triangle-exclamation';
                                            $ctt = 'Hampir benar keseluruhan jawaban';
                                        } else {
                                            $color = 'danger';
                                            $icon = 'times';
                                            $ctt = '';
                                        }
                                    @endphp
                                    <span class="text-{{$color}} ms-1">
                                        <i class="fa fa-{{$icon}}"></i>
                                    </span> <strong style="font-size: 12px;">{{$ctt}}</strong>
                                </td>
                                <td>{{$data->nilai[$key]}} 
                                @php
                                    // isian singkat = 4
                                    // essay = 5
                                    $soal_koreksi = ['5', '4'];
                                @endphp
                                @if (in_array($item->tipe_soal_id, $soal_koreksi) && auth()->user()->role == 'teacher' && $data->nilai[$key] == '0')
                                    {{-- tombol koreksi nilai --}}
                                    <a href="{{route('rapor.teacher.koreksi', [$data->id, 'index'=>$key])}}" class="fa fa-edit text-warning ms-1 btn-koreksi"></a>
                                @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">No data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($data->is_selesai == '0' && $data->Soal->created_by == auth()->user()->id && auth()->user()->role == 'teacher')
                    <a href="{{route('rapor.teacher.submit', $data->id)}}" onclick="return confirm('Apa anda yakin akan submit rapor ini?')" class="form-control btn btn-success">Submit</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

<script>
    
    $('.btn-feedback').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var modalSize = $(this).attr('data-modal') ?? '';

        $.ajax({
            url: url,
            dataType: 'HTML',
            method: 'GET',
            success: function (result) {
                modalForm(result, 'Feedback', 'modal-xl');
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $('.btn-koreksi').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var modalSize = $(this).attr('data-modal') ?? '';

        $.ajax({
            url: url,
            dataType: 'HTML',
            method: 'GET',
            success: function (result) {
                modalForm(result, 'Koreksi Soal', 'modal-xs');
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

</script>
@endpush