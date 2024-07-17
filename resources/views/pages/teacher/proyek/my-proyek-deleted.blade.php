@extends('layouts.app')

@section('title', 'Proyek')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Proyek Saya</h1>
</div>


<div class="container">
    <div class="row row-cols-md-3 row-cols-lg-6">
      @forelse ($data as $item)
        <div class="col mb-2 text-center">
            <div class="d-inline-block position-relative">
                <img src="{{asset('uploads/'.$item->cover)}}" alt="err" width="50px" height="50px" /><a href="{{route('proyek.redo', $item->id)}}" title="Kembalikan proyek" onclick="return confirm('Apa anda yakin menyimpan proyek ini?')"  class=" bg-primary text-white rounded-circle position-absolute" style="bottom: 0; right: 0;">
                    <i class="align-middle p-1" data-feather="rotate-ccw"></i> 
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