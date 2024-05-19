@extends('layouts.app')

@section('title', 'Soal')

@section('content')

<form id="soalForm" action="{{route('soal.update', $soal->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    
    {{-- <div class="row mb-3">
        <div class="col-md-4 alert alert-success ">
            <h4>Proyek <strong>{{$soal->Proyek->nama}}</h4>
        </div>
    </div> --}}
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
                                        <i class="fa fa-plus p-2"></i> 
                                    </a>
                                    <span class="mx-3"></span>
                                    <a href="javascript:;" id="btnSiswaRemove" class=" bg-danger text-white rounded-circle position-absolute">
                                        <i class="fa fa-trash p-2"></i> 
                                    </a>
                                </div>
                            </div>
                            
                            <div class="appendArea">
                                @foreach ($soal->pernyataan as $item)
                                <input type="text" name="pernyataan[]" class="form-control mb-3 pernyataan" value="{{$item}}" placeholder="Misalkan nama, nisn, kelas" required />
                                @endforeach
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
                                        <input type="text" class="form-control" value="{{$soal->nama}}" name="nama" placeholder="Misalkan Fotosintesis, Tata surya, dll" />
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="col-md-6">
                                    <h5 class="card-title my-3">Durasi Ujian <span class="text-danger">*</span></h5>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" value="{{$soal->waktu_ujian}}" name="waktu_ujian" placeholder="Misalkan 30 menit" />
                                        <span class="input-group-text">menit</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="card-title my-3">Batch <span class="text-danger">*</span></h5>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{$soal->batch}}" name="batch" placeholder="Batch" />
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
                            <span class="mb-3 me-1">Cover Ujian </span>
                        </div>
                    </div>
                        
                    <input type="file" name="cover" class="form-control mb-3 cover" />

                    <span>Preview</span>
                    <div class="col-md text-center mt-3">
                        <img src="{{asset($soal->cover ? 'uploads/'.$soal->cover : 'dist/img/no-img.png')}}" alt="preview" id="previewImg" class="rounded" width="200px" height="auto"/>
                    </div>

                </div>
            </div>
        </div>
        
    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    
                    <div class="col-md ">
                        <h5 class="card-title my-3">Dapat diakses mandiri <span class="text-danger">*</span></h5>
                        <div class="input-group mb-3">
                            <select class="form-control form-select mb-3 is-mandiri" name="is_mandiri" required>
                                <option value="">-- PILIH --</option>
                                <option {{$soal->is_mandiri == true ? 'selected' : ''}} value="1">Ya</option>
                                <option {{$soal->is_mandiri == false ? 'selected' : ''}} value="0">Tidak</option>
                            </select>
                        </div>

                        <div class="token-div {{$soal->is_mandiri == true ? 'd-none' : ''}}">
                            <div class="input-group mb-3">
                                @php
                                    if ($soal->is_mandiri == false) {
                                        $explode = explode(' ', $soal->waktu_akses_ujian);
                                        $waktu = explode(':', $explode[1]);
                                        array_pop($waktu);
    
                                        $jam_ujian = implode(':',$waktu);
                                        $tanggal_ujian = $explode[0];
                                    }
                                @endphp
                                <input type="text" class="form-control time-picker" readonly value="{{$jam_ujian ?? null}}" name="jam_ujian" placeholder="HH:MM" required />
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control date-picker" readonly value="{{$tanggal_ujian ?? null}}" name="tanggal_ujian" placeholder="yyyy-mm-dd" required />
                            </div>

                            {{-- <h5 class="card-title my-3">Kode <span class="text-danger">*</span></h5>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control token-value" readonly name="token" required />
                            </div> --}}
                        </div>
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
            if (pernyataan.length > 1) {
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

    <script>
        var timePicker = $('.time-picker');
        var datePicker = $('.date-picker');

        $('.is-mandiri').on('change', function(e){
            var isMandiri = e.currentTarget.value;
            var tokenValue = $('.token-value');
            var tokenDiv = $('.token-div');

            if (isMandiri === '0') {
                tokenValue.val(generateRandomString());
                tokenDiv.hasClass('d-none') ? tokenDiv.removeClass('d-none') : '';
                return;
            }
            timePicker.val('');
            datePicker.val('');
            tokenValue.val('');
            !tokenDiv.hasClass('d-none') ? tokenDiv.addClass('d-none') : '';

        });

        $('#soalForm').submit(function(e){
            if (timePicker.val() == '' || datePicker.val() == '') {
                e.preventDefault();
                alert('Data harus diisi semua!');
            }
        });

        function generateRandomString() {
            let result = '';
            let soalId = "{{$soal->id}}";
            let soalTahun = "{{date('Y', strtotime($soal->created_at))}}"
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            const charactersLength = characters.length;
            for (let i = 0; i < 5; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return soalId + result + soalTahun;
        }
        
        $('.time-picker').timepicker({
            uiLibrary: 'bootstrap5',
            mode: '24hr',
        });

        $('.date-picker').datepicker({
            uiLibrary: 'bootstrap5',
            iconsLibrary: 'fontawesome',
            format: 'yyyy-mm-dd'
        });
    </script>
@endpush