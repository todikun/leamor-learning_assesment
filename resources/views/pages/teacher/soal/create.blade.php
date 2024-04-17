@extends('layouts.app')

@section('title', 'Soal')

@section('content')

<form action="{{route('soal.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="proyek_id" value="{{$proyek->id}}" />

    <div class="row mb-3">
        <div class="col-md-4 alert alert-success ">
            <h4>Proyek <strong>{{$proyek->nama}}</h4>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col-md-6">
            <div class="d-inline">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex mb-3">
                                <div class="col-md">
                                    <span class="mb-3 me-1">Identitas Siswa</span>
                                    <a href="javascript:;" id="btnSiswaAdd" class=" me-3 bg-success text-white rounded-circle position-absolute">
                                        <i class="align-middle p-1" data-feather="plus"></i> 
                                    </a>
                                    <span class="mx-3"></span>
                                    <a href="javascript:;" id="btnSiswaRemove" class=" bg-danger text-white rounded-circle position-absolute">
                                        <i class="align-middle p-1" data-feather="trash"></i> 
                                    </a>
                                </div>
                            </div>
                            
                            <input type="text" name="pernyataan[]" class="form-control mb-3" placeholder="Misalkan nama, nisn, kelas" required />
                            <div class="appendArea">

                            </div>
                        </div>
                    </div>
                </div> 
        
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md">
                                    <h5 class="card-title my-3">Topik <span class="text-danger">*</span></h5>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="nama" placeholder="Misalkan Fotosintesis, Tata surya, dll" />
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="col-md-6">
                                    <h5 class="card-title my-3">Durasi Ujian <span class="text-danger">*</span></h5>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="waktu_ujian" placeholder="Misalkan 30 menit" />
                                        <span class="input-group-text">menit</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title my-3">Waktu Feedback <span class="text-danger">*</span></h5>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" name="waktu_feedback" placeholder="Misalkan 30 menit" />
                                        <span class="input-group-text">menit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex mb-3">
                        <div class="col-md">
                            <span class="mb-3 me-1">Cover Ujian <span class="text-danger">*</span></span>
                        </div>
                    </div>
                        
                    <input type="file" name="cover" class="form-control mb-3 cover" required />

                    <span>Preview</span>
                    <div class="col-md text-center mt-3">
                        <img src="{{asset('dist/img/no-img.png')}}" alt="preview" id="previewImg" class="rounded" width="200px" height="auto"/>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
    <button type="submit" class="btn btn-success position-fixed my-5 mx-5" style="bottom: 0; right: 0;">
        SAVE
    </button>

</form>
@endsection

@push('script')
    <script>
        var btnSiswaAdd = $('#btnSiswaAdd'); 
        var btnSiswaRemove = $('#btnSiswaRemove'); 
        var appendArea = $('.appendArea'); 
        var inputHtml = `
            <input type="text" name="pernyataan[]" class="form-control mb-3 pernyataan" placeholder="Misalkan nama, nisn, kelas" required />
        `;

        btnSiswaAdd.on('click', function(){
            appendArea.append(inputHtml);
        });

        btnSiswaRemove.on('click', function(){
            var pernyataan = appendArea.find('.pernyataan');
            if (pernyataan.length > 0) {
                pernyataan.last().remove();
            }
        });
    </script>

    <script>
        $('.cover').on('change', function(){
            let file = $(this)[0].files[0];
            if (!file) return;
            if (!file.type.includes('image'))  return alert('File format not supported!')
            
            var reader = new FileReader();
            var previewImg = $('#previewImg');

            reader.onload = function (e) {
                previewImg.attr('src', e.target.result)
            };

            reader.readAsDataURL(file);
        });
    </script>
@endpush