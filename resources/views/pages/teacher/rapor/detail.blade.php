@extends('layouts.app')

@section('title', 'Soal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Rapor Ujian: <strong>{{$data->nama ?? '-'}}</strong> </h1>
    <div class="col-md-4 d-flex">
        <h1 class="h3">Filter:</h1>
        <select name="filter" class="form-control form-select ms-3" onchange="sortData(this)">
            <option {{request()->get('sort') == 'nama' ? 'selected':''}} value="nama">Nama</option>
            <option {{!request()->get('sort') || request()->get('sort') == 'rank' ? 'selected':''}} value="rank">Rank</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="myTable" class="table">
                    <thead style="background-color: #79dfc1">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Nilai</th>
                            <th>Rank</th>
                            <th>Waktu Pelaksanaan</th>
                            <th>File Ujian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->UjianSiswa ?? collect() as $item)
                            <tr class="text-center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->Siswa->nama}}</td>
                                <td>{{$item->total_nilai}}</td>
                                <td>{{$item->rank ?? $loop->iteration}}</td>
                                <td>{{date('d F Y H:i', strtotime($item->created_at))}}</td>
                                <td>
                                    <a href="{{route('rapor.teacher.rank', [$data->id, $item->id])}}" class="btn btn-secondary">
                                        <i class="align-middle" data-feather="file"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">No data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

<script>
    
    function sortData(e) {
        if (e.value != '') {
            let url = "{{route('rapor.teacher.detail', $data->id)}}";
            window.location.replace(url+'?sort='+e.value);
        }
    }
    // event button edit
    $('.btn-add').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var modalSize = $(this).attr('data-modal') ?? '';

        $.ajax({
            url: url,
            dataType: 'HTML',
            method: 'GET',
            success: function (result) {
                $('#modal-form').find('#modal-label').html('Tambah Pasien');
                $('#modal-form').find('.modal-dialog').addClass(modalSize);
                $('#modal-form').find('.modal-body').html(result);
                $('#modal-form').modal('show');
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $('.btn-edit').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            dataType: 'HTML',
            method: 'GET',
            success: function (result) {
                $('#modal-form').find('#modal-label').html('Edit Gejala');
                $('#modal-form').find('.modal-body').html(result);
                $('#modal-form').modal('show');
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $('.btn-token').on('click', function(){
        let icon = $(this).find('.icon');
        let tokenShow = $('.token-show');
        let tokenHide = $('.token-hide');
        if (icon.hasClass('fa-eye-slash')) {
            icon.removeClass('fa-eye-slash');
            icon.addClass('fa-eye');
            tokenShow.removeClass('d-none');
            tokenHide.addClass('d-none');
            return;
        }
        icon.addClass('fa-eye-slash');
        icon.removeClass('fa-eye');
        tokenShow.addClass('d-none');
        tokenHide.removeClass('d-none');
    });

</script>
@endpush