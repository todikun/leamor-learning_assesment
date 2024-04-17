@extends('layouts.app')

@section('title', 'Proyek')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Proyek Saya</h1>
    <a href="{{ route('proyek.create') }}" class="btn btn-primary btn-add">
        <i class="align-middle" data-feather="plus"></i> Create Proyek
    </a>
</div>


<div class="container">
    <div class="row row-cols-md-3 row-cols-lg-6">
      @forelse ($data as $item)
        <div class="col mb-2 text-center">
            <div class="d-inline-block position-relative">
                <a href="{{route('soal.index', ['proyek'=>$item->id])}}">
                    <img src="{{asset('dist/img/folder.png')}}" alt="err" width="50px" height="50px" />
                </a>
                <a href="{{route('proyek.edit', $item->id)}}" title="Edit proyek" class="btn-edit bg-warning text-white rounded-circle position-absolute" style="bottom: 0; right: 0;">
                    <i class="align-middle p-1" data-feather="edit-2"></i> 
                </a>
            </div>            
            <h5 class="fw-bold">{{$item->nama}}</h5>
        </div>
      @empty
          Data Not Found!
      @endforelse
    </div>
</div>

@endsection

@push('script')

<script>

    // event button add
    $('.btn-add').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            dataType: 'HTML',
            method: 'GET',
            success: function (result) {
                $('#modal-form').find('.modal-title').html('Create Proyek');
                $('#modal-form').find('.modal-body').html(result);
                $('#modal-form').modal('show');
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
    
    // event button edit
    $('.btn-edit').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            dataType: 'HTML',
            method: 'GET',
            success: function (result) {
                $('#modal-form').find('.modal-title').html('Edit Proyek');
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