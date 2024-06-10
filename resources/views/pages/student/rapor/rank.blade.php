@extends('layouts.app')

@section('title', 'Soal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Rapor Ujian: <strong>{{$data->Soal->nama ?? '-'}}</strong> </h1>
    <h2 class="h3"> Peringkat: <strong>{{$rank}}</strong>, Total Skor: <strong>{{$data->total_nilai}}</strong></h2>
    <a href="{{route('export', $data->soal_id)}}" class="btn btn-danger">
        <i class="fa fa-file"></i> PDF
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="myTable" class="table">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tipe Soal</th>
                            <th>Soal</th>
                            <th>Feedback</th>
                            <th>Jawaban</th>
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
                                    @php
                                        $guruFeedback = $data->UjianSiswaFeedback->where('ujian_siswa_id', $data->id)->where('soal_detail_id',$item->id)->first();
                                    @endphp
                                    @if (!isset($guruFeedback) && auth()->user()->role == 'teacher')
                                        <a href="{{route('rapor.teacher.feedback', [$data->id,'index'=>$item->id])}}" class="text-danger btn-feedback">Isi feedback</a>
                                    @else
                                        {!!$guruFeedback->feedback ?? '-'!!}</td>    
                                    @endif
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
                                    <span class="text-{{$data->nilai[$key] != '0' ? 'success':'danger'}} ms-1">
                                        <i class="fa fa-{{$data->nilai[$key] != '0' ? 'check':'times'}}"></i>
                                    </span>
                                </td>
                                <td>{{$data->nilai[$key]}} 
                                @php
                                    // essay = 5
                                    $soal_koreksi = ['5']
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
                modalForm(result, 'Update Feedback');
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