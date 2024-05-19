@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="row justify-content-md-center text-center d-flex">
          <div class="pb-3 mb-3">

            @if (auth()->user()->role == 'teacher')
                <a class="btn btn-success rounded-circle" href="{{route('soal.create')}}">
                    <i class="align-middle" data-feather="plus"></i> 
                </a>
                <h5 class="mt-2">Create Proyek</h5>
            @endif

            @if (auth()->user()->role == 'student')
                <img src="{{asset('dist/img/fighting.png')}}" alt="err" height="300px" width="auto" />

                <form action="{{route('ujian.akses')}}" method="POST">
                    @csrf
                    <div class="row row justify-content-md-center mt-2">
                        <div class="col-4">
                            <input type="text" name="token" placeholder="Kode Akses" class="form-control mb-2" required />
                            <button type="submit" class="form-control btn btn-success mb-2">Submit</button>
                        </div>
                    </div>
                </form>
            @endif

          </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        $('.btn-add').on('click',function(e){
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
    </script>
@endpush