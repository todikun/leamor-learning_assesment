@extends('layouts.app')

@section('title', 'Soal')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Proyek {{$proyek->nama}} </h1>
    <a href="{{ route('soal.create', ['proyek'=>$proyek->id]) }}" class="btn btn-primary ">
        <i class="align-middle" data-feather="plus"></i> Create Soal
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <table id="myTable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Waktu Ujian</th>
                            <th>Waktu Feedback</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->waktu_ujian}} menit</td>
                                <td>{{$item->waktu_feedback}} menit</td>
                                <td>
                                    <a href="{{ route('soal.show', $item->id) }}"
                                        class="btn btn-sm btn-secondary">
                                        <i class="fa fa-edit"></i> Soal
                                    </a>
                                    <a href="{{ route('soal.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning btn-edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('soal.destroy', $item->id) }}"
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

</script>
@endpush