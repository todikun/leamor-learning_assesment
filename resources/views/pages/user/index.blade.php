@extends('layouts.app')

@section('title', 'Manajemen Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Manajemen Siswa</h1>
    <a href="{{ route('user.create') }}" class="btn btn-success btn-add">
        <i class="align-middle" data-feather="plus"></i> Tambah Siswa
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="myTable" class="table">
                    <thead>
                        <tr class="text-center" style="background-color: #79dfc1;">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr class="text-center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->username}}</td>
                                <td>
                                    <a href="{{route('user.edit', $item->id)}}" class="btn btn-warning btn-sm btn-edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('user.destroy', $item->id) }}"
                                        method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah yakin data ini ingin dihapus?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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
                $('#modal-form').find('#modal-label').html('Tambah');
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
                $('#modal-form').find('#modal-label').html('Edit');
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