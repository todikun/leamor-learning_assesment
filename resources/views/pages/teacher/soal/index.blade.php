@extends('layouts.app')

@section('title', 'Soal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3"></h1>
    <div>

        <a href="{{ route('proyek.my') }}" class="btn btn-secondary">
            <i class="align-middle" data-feather="folder"></i> Folder View
        </a>

        <a href="{{ route('soal.create') }}" class="btn btn-success ">
            <i class="align-middle" data-feather="plus"></i> Create Soal
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="myTable" class="table">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Akses Ujian</th>
                            <th>Durasi Ujian</th>
                            <th>Akses Mandiri</th>
                            <th>Kode Akses</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr class="text-center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>@if ($item->waktu_akses_ujian == null)
                                    <span class="badge bg-secondary">setiap saat</span>
                                @else
                                {{date('d F Y H:i', strtotime($item->waktu_akses_ujian))}}
                                @endif

                                </td>
                                <td>{{$item->waktu_ujian}} menit</td>
                                <td>
                                    <h1 class="text-{{$item->is_mandiri == true ? 'success' : 'danger'}}">
                                        <i class="fa fa-{{$item->is_mandiri == true ? 'check' : 'times'}}"></i>
                                    </h1>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center token-container">
                                        @if ($item->is_mandiri == true)
                                        <h1 class="text-danger">
                                            <i class="fa fa-times"></i>
                                        </h1>
                                        @else
                                        <h5 class="token-show fw-bold d-none">{{$item->token}}</h5>
                                        <h3 class="token-hide fw-bold">*********</h3>
                                        <span style="cursor: pointer;" class="text-dark ms-2 btn-token">
                                            <i class="icon fa fa-eye-slash"></i>
                                        </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('soal.users', $item->id) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="fa fa-users"></i> 
                                    </a>
                                    <a href="{{ route('soal.preview', $item->id) }}"
                                        class="btn btn-sm btn-secondary">
                                        <i class="fa fa-eye"></i> Preview
                                    </a>
                                    <a href="{{ route('soal.show', $item->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i> Soal
                                    </a>

                                    <a href="{{ route('proyek.undo', $item->id) }}"
                                        class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i> 
                                    </a>
                                    <a href="{{ route('soal.edit', $item->id) }}"
                                        class="btn btn-sm btn-secondary">
                                        <i class="fa fa-gear"></i>
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
        let tokenShow = $(this).closest('.token-container').find('.token-show');
        let tokenHide = $(this).closest('.token-container').find('.token-hide');
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