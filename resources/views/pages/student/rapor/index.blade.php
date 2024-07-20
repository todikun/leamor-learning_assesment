@extends('layouts.app')

@section('title', 'Rapor')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Rapor Saya</h1>
    {{-- <div>
        <a href="{{ route('soal.index') }}" class="btn btn-secondary">
            <i class="align-middle" data-feather="list"></i> List View
        </a>

        <a href="{{ route('soal.create') }}" class="btn btn-success">
            <i class="align-middle" data-feather="plus"></i> Create Proyek
        </a>
    </div> --}}
</div>


<div class="container">
    <div class="row row-cols-md-3 row-cols-lg-6">
      @forelse ($data as $item)
        <div class="col mb-2 text-center">
            <div class="d-inline-block position-relative">
                <a href="#" style="cursor: default">
                    <img src="{{asset('uploads/'.$item->cover)}}" alt="err" width="50px" height="50px" />
                </a>
                <a href="{{route('rapor.student.detail', $item->id)}}" title="Rapor" class=" bg-success text-white rounded-circle position-absolute" style="bottom: 0; right: 0;">
                    <i class="align-middle p-1" data-feather="file"></i> 
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