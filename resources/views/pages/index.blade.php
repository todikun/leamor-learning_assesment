@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="row justify-content-md-center text-center d-flex">
          <div class="pb-3 mb-3">
            <a class="btn btn-success rounded-circle btn-add" href="{{route('proyek.create')}}">
                <i class="align-middle" data-feather="plus"></i> 
            </a>
            <h5 class="mt-2">Create Proyek</h5>
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