@extends('layouts.app')

@section('title', 'Soal')

@section('content')

<form id="formSoal" action="{{route('soal.create_update')}}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="soal_id" value="{{$soal->id}}" />

    <div class="row mb-3">
        <div class="col-md-4 alert alert-success ">
            <h5>Topik <strong>{{$soal->nama}}</h5>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col-md-1">
            <div class="d-inline">

                <div class="col-md-12">
                    <h3 class="mb-2">Soal</h3>
                    <div class="col-md-6 mb-3">
                        <a href="javascript:;" id="btnSoalAdd" class=" me-3 bg-success text-white rounded-circle position-absolute">
                            <i class="fa fa-plus p-2"></i> 
                        </a>
                        <span class="mx-3"></span>
                        <a href="javascript:;" id="btnSoalRemove" class=" bg-danger text-white rounded-circle position-absolute">
                            <i class="fa fa-times p-2"></i> 
                        </a>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3 cek-nav-link" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @if (!$detailSoal->isEmpty())
                                @foreach ($detailSoal as $key => $item)
                                    <button class="nav-link {{$key+1 == 1 ? 'active' : ''}}"  id="v-pills-soal_{{$key+1}}-tab" data-index="{{$key+1}}" data-bs-toggle="pill" data-bs-target="#v-pills-soal_{{$key+1}}" type="button" role="tab" aria-controls="v-pills-soal_{{$key+1}}" aria-selected="true">{{$key+1}}</button>
                                @endforeach
                            @else
                                <button class="nav-link active"  id="v-pills-soal_1-tab" data-index="1" data-bs-toggle="pill" data-bs-target="#v-pills-soal_1" type="button" role="tab" aria-controls="v-pills-soal_1" aria-selected="true">1</button>
                            @endif
                        </div>
                    </div>
                      
                </div>
        
            </div>
        </div>

        
        <div class="col-md-11">
            
            <div class="tab-content" id="v-pills-tabContent">
                @if (!$detailSoal->isEmpty())
                    @foreach ($detailSoal as $key => $item)
                        <div class="tab-pane fade show {{$key+1 == 1 ? 'active' : '' }}" id="v-pills-soal_{{$key+1}}" role="tabpanel" aria-labelledby="v-pills-soal_{{$key+1}}-tab">
                            <div class="row d-flex">
                                <div class="col-md-6">
                
                                    {{-- stimulus --}}
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row d-flex mb-3">
                                                    <div class="col-md">
                                                        <span class="mb-3 me-1">Stimulus <span class="text-danger">*</span></span>
                                                        <a href="javascript:;" onclick="stimulusAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                            <i class="fa fa-plus p-2"></i> 
                                                        </a>
                                                        <span class="mx-3"></span>
                                                        <a href="javascript:;" onclick="stimulusRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                            <i class="fa fa-times p-2"></i> 
                                                        </a>
                                                    </div>
                                                </div>
                                                
                                                <div class="appendAreaStimulus_{{$key+1}}">
                                                    @forelse ($item->stimulus as $stimulus)
                                                        <div class="row d-flex stimulus-container mb-2">
                                                            <div class="col-md-4">
                                                                <select name="{{$key+1}}_stimulus_tipe[]" class="form-control form-select stimulus-select mb-2" onchange="changeStimulus(this)" required>
                                                                    <option value="">-- PILIH --</option>
                                                                    <option {{$stimulus['tipe'] == 'teks' ? 'selected' : ''}} value="teks">Teks</option>
                                                                    <option {{$stimulus['tipe'] == 'dokumen' ? 'selected' : ''}} value="dokumen">Dokumen</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md stimulus-tipe">
                                                                @if ($stimulus['tipe'] == 'teks')
                                                                    <textarea name="{{$key+1}}_stimulus[]" class="form-control mb-2 text-stimulus stimulus-summernote" cols="3" rows="3" required="required">{{$stimulus['value']}}</textarea>
                                                                @else
                                                                    {{-- <input name="{{$key+1}}_stimulus[]" type="file" class="form-control mb-2" required="required"> --}}
                                                                    <div class="row d-flex">
                                                                        <div class="col">
                                                                            <input type="file" class="form-control mb-2" onchange="tmpUpload(this)" />
                                                                            <input name="{{$key+1}}_stimulus[]" value="{{$stimulus['value']}}" type="hidden" class="form-control gambar file-stimulus mb-1 text-stimulus" />
                                                                        </div>
                                                                        <div class="col-auto">
                                                                            <button type="button" class="btn btn-icon btn-show" onclick="previewStimulus(this)" data-url="/uploads/{{$stimulus['value']}}" data-value="{{$stimulus['value']}}" aria-label="Button">
                                                                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                                    <path
                                                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                            
                                            </div>
                                        </div>
                                    </div>

                                    {{-- feedback --}}
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-2">Feedback </h5>
                                                    <textarea name="feedback[]" class="form-control feedback-summernote" cols="3" rows="3">{!!$item->feedback!!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                
                                </div>
                        
                                {{-- opsi --}}
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                
                                            <div class="form-group mb-2">
                                                <h5 class="card-title mb-2">Pertanyaan <span class="text-danger">*</span></h5>
                                                <textarea name="pertanyaan[]" class="summernote">{{$item->pertanyaan}}</textarea>
                                            </div>
                
                                            <div class="form-group mb-2">
                                                <h5 class="card-title mb-2">Tipe Soal <span class="text-danger">*</span></h5>
                                                <select name="tipe_soal_id[]" onchange="changeOpsi(this)" class="form-control form-select mb-3 tipe-soal_1" required>
                                                    <option value="">-- PILIH --</option>
                                                    @foreach ($tipeSoal as $tipe)
                                                        <option {{$tipe->id == $item->tipe_soal_id ? 'selected':''}} value="{{$tipe->id}}">{{$tipe->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-2">
                                                <h5 class="card-title mb-2">Skor <span class="text-danger">*</span></h5>
                                                <input type="number" class="form-control mb-2" value="{{$item->skor}}" placeholder="Skor" name="skor[]" required/>
                                            </div>
                
                                            <hr>
                
                                            <div class="appendAreaOpsi_{{$key+1}}">
                                                <div class="row d-flex mb-3">
                                                    <div class="col-md btn-add-remove-opsi {{$item->tipe_soal_id  != '3' ? 'd-none':''}}">
                                                        {{-- <span class="mb-3 me-1">Opsi <span class="text-danger">*</span></span> --}}
                                                        <a href="javascript:;" onclick="opsiAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                            <i class="fa fa-plus p-2"></i> 
                                                        </a>
                                                        <span class="mx-3"></span>
                                                        <a href="javascript:;" onclick="opsiRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                            <i class="fa fa-times p-2"></i> 
                                                        </a>

                                                        <div class="judul-benar-salah">
                                                            @if ($item->tipe_soal_id == '3')
                                                                <div class="d-flex justify-content-center mt-3 mb-2">
                                                                    <div class="col-md-6 text-center mb-2 mx-auto">
                                                                        <textarea class="form-control mb-2" name="{{$key+1}}_judul" placeholder="Judul" style="height: 12px;" required>{{$item->opsi_jawaban['judul']}}</textarea>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>

                                                    </div>
                                                    
                                                    {{-- <div class="btn-add-remove-opsi-mencocokan d-none">
                                                        <div class="row d-flex">
                                                            <div class="col-md-6">
                                                                <a href="javascript:;" onclick="opsiAdd(this, 'kiri')" class="bg-success text-white rounded-circle position-absolute ">
                                                                    <i class="fa fa-plus p-2"></i> 
                                                                </a>
                                                                <a href="javascript:;" onclick="opsiRemove(this, 'kiri')" class="ms-5 bg-danger text-white rounded-circle position-absolute">
                                                                    <i class="fa fa-times p-2"></i> 
                                                                </a>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <a href="javascript:;" style="float:right;" onclick="opsiRemove(this, 'kanan')" class="ms-3 bg-danger text-white rounded-circle ">
                                                                    <i class="fa fa-times p-2"></i> 
                                                                </a>
                                                                <a href="javascript:;" style="float:right;" onclick="opsiAdd(this, 'kanan')" class="bg-success text-white rounded-circle ">
                                                                    <i class="fa fa-plus p-2"></i> 
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                </div>
                                                
                                                <div class="col-md opsi-jawaban">
                                                    @php
                                                        $pilihan_ganda = ['A','B','C','D'];
                                                        $tipe_soal = $item->tipe_soal_id;
                                                    @endphp
                                                        @switch($item->tipe_soal_id)
                                                            @case('1')
                                                                @foreach ($pilihan_ganda as $index => $pilihan)
                                                                {{-- pilihan ganda --}}  
                                                            
                                                                    <div class="pilihan-ganda-opsi opsi-remove mb-3 d-flex align-items-center justify-content-center">
                                                                        <div class="col-md-1 align-items-center justify-content-center soal_{{$key+1}}">
                                                                            <input type="checkbox" onclick="pilihanGandaOpsiMaxTwoChecked({{$key+1}})" {{in_array($pilihan, $item->kunci_jawaban) ? 'checked':''}} value="{{$pilihan}}" name="{{$key+1}}_kunci_jawaban[]" class="opsi" />
                                                                            <span style="font-size: 14px;">{{$pilihan}}</span>
                                                                        </div>
                                                                        <div class="col-md-11">
                                                                            <div>
                                                                                <textarea class="form-control mb-2 summernote" name="{{$key+1}}_opsi_jawaban[]" cols="3" rows="3">{{$item->opsi_jawaban[$index]}}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                @break
                                                            @case('2')
                                                            {{-- mencocokan --}}
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="col-md-4 text-center mb-2 mx-auto">
                                                                        <textarea class="form-control mb-2" name="{{$key+1}}_judul_kiri" placeholder="Judul" style="height: 12px;" required>{{$item->opsi_jawaban['judul']['kiri']}}</textarea>
                                                                    </div>
                                                                    <div class="col-md-2 text-center mb-2 mx-auto">
                                                                        <p class="mb-2">Jawaban</p>
                                                                    </div>
                                                                    <div class="col-md-4 text-center mb-2 mx-auto">
                                                                        <textarea class="form-control mb-2" name="{{$key+1}}_judul_kanan" placeholder="Judul" style="height: 12px;" required>{{$item->opsi_jawaban['judul']['kanan']}}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="d-flex mt-3 mb-2">
                                                                    <div class="col-md-4 opsi-kiri">
                                                                        @foreach ($item->opsi_jawaban['opsi_jawaban_kiri'] as $no => $opsi)
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon1">{{$no+1}}</span>
                                                                                </div>
                                                                                <textarea class="form-control mb-2" name="{{$key+1}}_opsi_jawaban_kiri[]" style="height: 12px;" required="">{{$opsi}}</textarea>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                    <div class="col-md-2 jawaban mx-auto">
                                                                        @foreach ($item->kunci_jawaban as $jawaban)
                                                                        <div class="mb-3">
                                                                            <input class="form-control" name="{{$key+1}}_kunci_jawaban[]" value="{{$jawaban}}">
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
            
                                                                    <div class="col-md-4 opsi-kanan ms-2">
                                                                        @foreach ($item->opsi_jawaban['opsi_jawaban_kanan'] as $no => $opsi)
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="basic-addon4">{{$no+1}}</span>
                                                                                </div>
                                                                                <textarea class="form-control mb-2" name="{{$key+1}}_opsi_jawaban_kanan[]" style="height: 12px;" required="">{{$opsi}}</textarea>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
            
                                                                </div>

                                                                @break
                                                            @case('3')  
                                                            {{-- benar salah --}}
                                                                @foreach ($item->opsi_jawaban['opsi'] as $baris => $opsi)
                                                                    <div class="opsi-remove mb-2 d-flex">
                                                                        <div class="col-md-8 me-2">
                                                                            <textarea class="form-control mb-2" name="{{$key+1}}_opsi_jawaban[]" required>{{$opsi}}</textarea>
                                                                        </div>
                                                                        <div class="col-md opsi-benar-salah_{{$key+1}} baris-{{$baris+1}}">
                                                                            <input type="checkbox" onchange="benarSalahOpsiChecked('benar', {{$baris+1}})" {{$item->kunci_jawaban[$baris] == 'benar' ? 'checked':''}} value="benar" class="opsi opsi-benar" name="{{$key+1}}_kunci_jawaban[]" /> Benar
                                                                            <input type="checkbox" onchange="benarSalahOpsiChecked('salah', {{$baris+1}})" {{$item->kunci_jawaban[$baris] == 'salah' ? 'checked':''}} value="salah" class="opsi opsi-salah" name="{{$key+1}}_kunci_jawaban[]" /> Salah
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                @break
                                                            @case('4')
                                                            {{-- isian singkat --}}
                                                            @foreach ($item->kunci_jawaban as $item)
                                                                <div class="opsi-remove mb-3 col-md-12">
                                                                    <textarea class="form-control mb-2" name="{{$key+1}}_opsi_jawaban[]" cols="3" rows="3" required>{{$item}}</textarea>
                                                                </div>
                                                                @endforeach
                                                                @break
                                                            @case('5')
                                                            {{-- essay --}}
                                                                <textarea class="form-control mb-2" name="{{$key+1}}_opsi_jawaban[]" cols="3" rows="3" required>{{$item->kunci_jawaban[0]}}</textarea>
                                                                @break
                                                            @default
                                                                
                                                        @endswitch
                                                </div>

                                            </div>
                
                                        </div>
                                    </div>
                                </div>
                
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="tab-pane fade show active" id="v-pills-soal_1" role="tabpanel" aria-labelledby="v-pills-soal_1-tab">
                        <div class="row d-flex">
                            <div class="col-md-6">

            
                                {{-- stimulus --}}
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row d-flex mb-3">
                                                <div class="col-md">
                                                    <span class="mb-3 me-1">Stimulus <span class="text-danger">*</span></span>
                                                    <a href="javascript:;" onclick="stimulusAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                        <i class="fa fa-plus p-2"></i> 
                                                    </a>
                                                    <span class="mx-3"></span>
                                                    <a href="javascript:;" onclick="stimulusRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                        <i class="fa fa-times p-2"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                            
                
                                            <div class="appendAreaStimulus_1">
                
                                                <div class="row d-flex stimulus-container mb-2">
                                                    <div class="col-md-4">
                                                        <select name="1_stimulus_tipe[]" class="form-control form-select stimulus-select mb-2" onchange="changeStimulus(this)" required>
                                                            <option value="">-- PILIH --</option>
                                                            <option value="teks">Teks</option>
                                                            <option value="dokumen">Dokumen</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md stimulus-tipe">
                    
                                                    </div>
                                                </div>

                                            </div>
                        
                                        </div>
                                    </div>
                                </div>

                                {{-- feedback --}}
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mb-2">Feedback </h5>
                                            <textarea name="feedback[]" class="form-control feedback-summernote" cols="3" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                    
                            {{-- opsi --}}
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
            
                                        <div class="form-group mb-2">
                                            <h5 class="card-title mb-2">Pertanyaan <span class="text-danger">*</span></h5>
                                            <textarea name="pertanyaan[]" class="summernote"></textarea>
                                        </div>
            
                                        <div class="form-group mb-2">
                                            <h5 class="card-title mb-2">Tipe Soal <span class="text-danger">*</span></h5>
                                            <select name="tipe_soal_id[]" onchange="changeOpsi(this)" class="form-control form-select mb-3 tipe-soal_1" required>
                                                <option value="">-- PILIH --</option>
                                                @forelse ($tipeSoal as $item)
                                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="form-group mb-2">
                                            <h5 class="card-title mb-2">Skor <span class="text-danger">*</span></h5>
                                            <input type="number" class="form-control mb-2" placeholder="Skor" name="skor[]" required />
                                        </div>
            
                                        <hr>
            
                                        <div class="appendAreaOpsi_1">
                                            <div class="row d-flex mb-3">
                                                <div class="col-md btn-add-remove-opsi d-none">
                                                    {{-- <span class="mb-3 me-1">Opsi <span class="text-danger">*</span></span> --}}
                                                    <a href="javascript:;" onclick="opsiAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                        <i class="fa fa-plus p-2"></i> 
                                                    </a>
                                                    <span class="mx-3"></span>
                                                    <a href="javascript:;" onclick="opsiRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                        <i class="fa fa-times p-2"></i> 
                                                    </a>
                                                    <div class="judul-benar-salah"></div>
                                                </div>

                                                <div class="btn-add-remove-opsi-mencocokan d-none">
                                                    <div class="row d-flex">
                                                        <div class="col-md-6">
                                                            <a href="javascript:;" onclick="opsiAdd(this, 'kiri')" class="bg-success text-white rounded-circle position-absolute ">
                                                                <i class="fa fa-plus p-2"></i> 
                                                            </a>
                                                            <a href="javascript:;" onclick="opsiRemove(this, 'kiri')" class="ms-5 bg-danger text-white rounded-circle position-absolute">
                                                                <i class="fa fa-times p-2"></i> 
                                                            </a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="javascript:;" style="float:right;" onclick="opsiRemove(this, 'kanan')" class="ms-3 bg-danger text-white rounded-circle ">
                                                                <i class="fa fa-times p-2"></i> 
                                                            </a>
                                                            <a href="javascript:;" style="float:right;" onclick="opsiAdd(this, 'kanan')" class="bg-success text-white rounded-circle ">
                                                                <i class="fa fa-plus p-2"></i> 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md opsi-jawaban" >

                                            </div>

                                        </div>
            
                                    </div>
                                </div>
                            </div>
            
                        </div>
                    </div>
                @endif
            </div>

        </div>
        
    </div>
    <button type="button" id="btnSubmit" class="btn btn-lg btn-success position-sticky my-7 mx-5" style="float: right;">
        SAVE
    </button>
    

</form>
@endsection

@push('script')
    {{-- soal --}}
    <script>
        var btnSoalAdd = $('#btnSoalAdd');
        var btnSoalRemove = $('#btnSoalRemove');
        var tabs = $('#v-pills-tab');
        var tabContents = $('#v-pills-tabContent');
        var globalIndex = 1;

        function setNilaiIndex(e) {
            globalIndex = parseInt($(e).attr('data-index'));
        }

        function tmpUpload(e)
        {
            var url = "{{route('soal.tmpfile')}}";
            var formData = new FormData();
            var file = e.files[0];
            var fileExtension = file.name.split('.').pop().toLowerCase();
            var allowedExtensions = ["mp3", "jpg", "jpeg", "png", "gif", "mp4"];

            if (allowedExtensions.indexOf(fileExtension) === -1) {
                e.value = null;
                return alert('Format file tidak didukung!')
            }

            formData.append('_token', "{{csrf_token()}}");
            formData.append('tmp', file);

            $.ajax({
                url: url,
                method: 'POST',
                processData: false, // Menggunakan false agar FormData tidak diubah menjadi string
                contentType: false, // Tidak menetapkan tipe konten karena FormData akan membentuknya sendiri
                type: 'JSON',
                data: formData,
                success: function(res){
                    var inputFile = $(e).closest('.stimulus-container').find('.stimulus-tipe .file-stimulus');
                    var btnShow = $(e).closest('.stimulus-container').find('.stimulus-tipe .btn-show');
                    btnShow.attr('data-url', '/tmp/' + res.data.name);
                    btnShow.attr('data-value', res.data.name);
                    inputFile.val(res.data.name);
                    console.log(res.data.name);
                    console.log(res);
                },
                error: function(err){
                    console.log(err);
                }
            });
        }

    //  soal    
        btnSoalAdd.on('click',function(){
            var navLink = tabs.find('.nav-link').last().attr('data-index'); 
            globalIndex = parseInt(navLink) + 1;

            var stimulusHtml = `
                <div class="row d-flex stimulus-container mb-2">
                    <div class="col-md-4">
                        <select name="${globalIndex}_stimulus_tipe[]" class="form-control form-select stimulus-select mb-2" onchange="changeStimulus(this)" required>
                            <option value="">-- PILIH --</option>
                            <option value="teks">Teks</option>
                            <option value="dokumen">Dokumen</option>
                        </select>
                    </div>
                    <div class="col-md stimulus-tipe">

                    </div>
                </div>
            `;

            // copy stimulus
            var isCopy = confirm('Copy stimulus?');
            if (isCopy) {
                stimulusHtml = $(`.appendAreaStimulus_${getIndexCurrentNavlinkActive()}`).html();
            } 

            var btnTabHtml = `
                <button class="nav-link" onclick="setNilaiIndex(this)" id="v-pills-soal_${globalIndex}-tab" data-index="${globalIndex}" data-bs-toggle="pill" data-bs-target="#v-pills-soal_${globalIndex}" type="button" role="tab" aria-controls="v-pills-soal_${globalIndex}" aria-selected="false">${globalIndex}</button>
            `;
            var contentTabHtml = 
            `
            <div class="tab-pane fade show" id="v-pills-soal_${globalIndex}" role="tabpanel" aria-labelledby="v-pills-soal_${globalIndex}-tab">
                <div class="row d-flex">
                    <div class="col-md-6">
    
                        {{-- stimulus --}}
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row d-flex mb-3">
                                        <div class="col-md">
                                            <span class="mb-3 me-1">Stimulus <span class="text-danger">*</span></span>
                                            <a href="javascript:;" onclick="stimulusAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                <i class="fa fa-plus p-2"></i> 
                                            </a>
                                            <span class="mx-3"></span>
                                            <a href="javascript:;" onclick="stimulusRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                <i class="fa fa-times p-2"></i> 
                                            </a>
                                        </div>
                                    </div>
                                    
        
                                    <div class="appendAreaStimulus_${globalIndex}">
                                    
                                        ${stimulusHtml}

                                    </div>
                
                                </div>
                            </div>
                        </div>

                        {{-- feedback --}}
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-2">Feedback </h5>
                                    <textarea name="feedback[]" class="form-control feedback-summernote" cols="3" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
            
                    {{-- opsi --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
    
                                <div class="form-group mb-2">
                                    <h5 class="card-title mb-2">Pertanyaan <span class="text-danger">*</span></h5>
                                    <textarea name="pertanyaan[]" class="summernote"></textarea>
                                </div>
    
                                <div class="form-group mb-2">
                                    <h5 class="card-title mb-2">Tipe Soal <span class="text-danger">*</span></h5>
                                    <select name="tipe_soal_id[]" onchange="changeOpsi(this)" class="form-control form-select mb-3 tipe-soal_${globalIndex}" required>
                                        <option value="">-- PILIH --</option>
                                        @forelse ($tipeSoal as $item)
                                            <option value="{{$item->id}}">{{$item->nama}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group mb-2">
                                    <h5 class="card-title mb-2">Skor <span class="text-danger">*</span></h5>
                                    <input type="number" class="form-control mb-2" placeholder="Skor" name="skor[]" required/>
                                </div>

                                <hr>
    
                                <div class="appendAreaOpsi_${globalIndex}">
                                    <div class="row d-flex mb-3">
                                        <div class="col-md btn-add-remove-opsi d-none">
                                            <a href="javascript:;" onclick="opsiAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                <i class="fa fa-plus p-2"></i> 
                                            </a>
                                            <span class="mx-3"></span>
                                            <a href="javascript:;" onclick="opsiRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                <i class="fa fa-times p-2"></i> 
                                            </a>

                                            <div class="judul-benar-salah"></div>

                                        </div>

                                        
                                    </div>
                                    <div class="col-md opsi-jawaban" >
                                        
                                    </div>

                                </div>
    
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
            `;

            tabs.append(btnTabHtml);
            tabContents.append(contentTabHtml);

            // ganti index nama file
            if (isCopy) {
                var stimulusIndex = $(`.appendAreaStimulus_${globalIndex}`);
                stimulusIndex.find('.stimulus-tipe .text-stimulus').attr('name', globalIndex + '_stimulus[]');
                stimulusIndex.find('.stimulus-select').attr('name', globalIndex + '_stimulus_tipe[]');
                stimulusIndex.find('.stimulus-select').addClass('is-copy');
                stimulusIndex.find('.stimulus-tipe .file-stimulus').attr('name', globalIndex + '_stimulus[]');
                
                // copy nilai element textarea sebelumnya
                stimulusIndex.find('.stimulus-tipe textarea').each(function(index){
                    var value = $(`.appendAreaStimulus_${navLink} .stimulus-tipe textarea`).eq(index).val();
                    $(this).text(value);
                });

                // remove required element file
                stimulusIndex.find('.stimulus-tipe input[type="file"]').each(function(index){
                    $(this).removeAttr('required');
                });
            }


            // tombol navigation tab
            var nextTab = $('.nav-link.active').next('.nav-link');
            nextTab.trigger('click');
            
            // re-init summernote
            summernote();
            feedbackSummernote();
        });

        btnSoalRemove.on('click',function(){
            var navLink = tabs.find('.nav-link'); 
            var tabPane = tabContents.find('.tab-pane');
            
            var prevTab = $('.nav-link.active').prev('.nav-link');
            prevTab.trigger('click');
            setTimeout(() => {
                if (navLink.length > 1) {
                    navLink.last().remove();
                    tabPane.last().remove();
                    globalIndex--;
                }
            }, 300);
        });

    //  stimulus 
        var btnStimulusAdd = $('.btnStimulusAdd'); 
        var btnStimulusRemove = $('.btnStimulusRemove'); 

        // form submit
        $('#btnSubmit').on('click', function(event) {
            let error = false;
            let requiredFields = $('#formSoal').find('input[required], select[required], textarea[required], input[type="file"][required]');
    
            requiredFields.each(function() {
                if ($(this).val() === "") {
                    error = true;
                }
            });

            if (error == true) {
                alert('Masih ada inputan yang kosong. Harap lengkapi terlebih dahulu sebelum submit form.')
            } else {
                $('#formSoal').submit();
            }
    
        });


        function getIndexCurrentNavlinkActive() {
            var index = '';
            $('.cek-nav-link').each(function() {
                index = $(this).find('.nav-link.active').data('index');
            });
            return index;
        }

        function stimulusAdd(e) {
            var index = getIndexCurrentNavlinkActive(); 
            var appendAreaStimulus = $(`.appendAreaStimulus_${index}`); 
            var inputHtml = `
                <div class="row d-flex stimulus-container mb-2">
                    <div class="col-md-4">
                        <select class="form-control form-select stimulus-select mb-2" name="${globalIndex}_stimulus_tipe[]" onchange="changeStimulus(this)" required>
                            <option value="">-- PILIH --</option>
                            <option value="teks">Teks</option>
                            <option value="dokumen">Dokumen</option>
                        </select>
                    </div>
                    <div class="col-md stimulus-tipe">

                    </div>
                </div>
                `;
            appendAreaStimulus.append(inputHtml);
        }

        function stimulusRemove(e) {
            var index = getIndexCurrentNavlinkActive();
            var appendAreaStimulus = $(`.appendAreaStimulus_${index}`).find('.stimulus-container');
            if (appendAreaStimulus.length > 1) {
                appendAreaStimulus.last().remove();
            }
        }
        
        function changeStimulus(e) {
            var index = getIndexCurrentNavlinkActive();
            var stimulusDiv = $(e).closest('.stimulus-container').find('.stimulus-tipe');
            
            if (stimulusDiv.children().length > 0) {
                stimulusDiv.children().remove();
            }

            var textarea = `
                <textarea name="${index}_stimulus[]" class="form-control mb-2 text-stimulus stimulus-summernote" cols="3" rows="3" required></textarea>
            `;

            var fileInput = `
                <div class="row d-flex">
                    <div class="col">
                        <input type="file" class="form-control mb-1" onchange="tmpUpload(this)" required />
                        <input name="${index}_stimulus[]" type="hidden" class="form-control gambar file-stimulus mb-1" />
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-icon btn-show" onclick="previewStimulus(this)" aria-label="Button">
                        <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path
                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                        </svg>
                        </a>
                    </div>
                </div>
            `;

            // cek value dan tambahkan attr selected pada value yg dipilih
            console.log('is-copy ', $(e).hasClass('is-copy'));
            $(e).find('option').removeAttr('selected');
            $(e).find('option:selected').attr('selected', 'true');

            switch ($(e).val()) {
                case 'teks':
                    stimulusDiv.append(textarea);
                    stimulusSummernote();
                    break;
                case 'dokumen':
                    stimulusDiv.append(fileInput);
                    stimulusDiv.append('<span class="text-danger" style="font-size: 12px; font-style: italic">Ukuran maks 10MB</span>');
                    break;
                default:
                    break;
            }
        }

    //  opsi 
        var btnOpsiAdd = $('.btnOpsiAdd'); 
        var btnOpsiRemove = $('.btnOpsiRemove'); 
        
        function opsiAdd(e, opsi = null) {
            
            var index = getIndexCurrentNavlinkActive();
            var tipeSoal = $(`.tipe-soal_${index}`);
            var appendAreaOpsi = $(`.appendAreaOpsi_${index}`).find('.opsi-jawaban');
            var indexBenarSalah = $(`.opsi-benar-salah_${index}`).length;
            
            var opsiBenarSalah = `
                <div class="opsi-remove mb-2 d-flex">
                    <div class="col-md-8 me-2">
                        <textarea class="form-control mb-2" name="${index}_opsi_jawaban[]" required></textarea>
                    </div>
                    <div class="col-md opsi-benar-salah_${index} baris-${indexBenarSalah+1}">
                        <input type="checkbox" onchange="benarSalahOpsiChecked('benar', ${indexBenarSalah+1})" value="benar" class="opsi opsi-benar" name="${index}_kunci_jawaban[]" /> Benar
                        <input type="checkbox" onchange="benarSalahOpsiChecked('salah', ${indexBenarSalah+1})" value="salah" class="opsi opsi-salah" name="${index}_kunci_jawaban[]" /> Salah
                    </div>
                </div>
            `;
            var opsiEssay = `
            <div class="opsi-remove mb-3 col-md-12">
                <textarea class="form-control mb-2" name="${index}_opsi_jawaban[]" cols="3" rows="3" required></textarea>
            </div>`;
            
            if (tipeSoal.val() == '') {
                alert('Pilih Tipe Soal terlebih dahulu!');
                tipeSoal.focus();
                if (appendAreaOpsi.children().length > 0) {
                    appendAreaOpsi.children().remove();   
                }
            } else if (tipeSoal.val() == '3'){
                appendAreaOpsi.append(opsiBenarSalah);
            }
        }

        function opsiRemove(e, opsi = null) {
            var index = getIndexCurrentNavlinkActive();
            var appendAreaOpsi = $(`.appendAreaOpsi_${index}`);
            var tipeSoal = $(`.tipe-soal_${index}`);
           
            if (opsi != null) {
                var elementKiri = appendAreaOpsi.find('.opsi-jawaban').find('.opsi-kiri').children();
                var elementKiriKunciJawaban = appendAreaOpsi.find('.opsi-jawaban').find('.kunci-jawaban-mencocokan').children();
            
                var elementKanan = appendAreaOpsi.find('.opsi-jawaban').find('.opsi-kanan').children();
                var elementKananKunciJawaban = appendAreaOpsi.find('.opsi-jawaban').find('.kunci-jawaban-mencocokan').find(`.baris-kanan-${elementKanan.length}`);

                if (opsi == 'kiri' && elementKiri.length > 1) {
                    elementKiri.last().remove();
                    elementKiriKunciJawaban.last().remove();
                }

                if (opsi == 'kanan' && elementKanan.length > 0) {
                    elementKanan.last().remove();
                    elementKananKunciJawaban.remove();
                }
                
            } else if (appendAreaOpsi.find('.opsi-jawaban .opsi-remove').length > 1) {
                appendAreaOpsi.find('.opsi-jawaban .opsi-remove').last().remove();
            }
        }

        function changeOpsi(e)
        {
            var index = getIndexCurrentNavlinkActive();
            var appendAreaOpsi = $(`.appendAreaOpsi_${index}`);
            var opsi = '';
            var content = '';
            appendAreaOpsi.find('.btn-add-remove-opsi').addClass('d-none');

            appendAreaOpsi.find('.opsi-jawaban').html('');
            appendAreaOpsi.find('.opsi-jawaban').removeClass('d-flex');

            switch ($(e).val() ?? e) {
                case '1':
                    // pilihan ganda
                    var pilihan = ['A','B','C','D'];
                    pilihan.forEach(value => {
                        content += `
                            <div class="opsi-remove pilihan-ganda-opsi mb-3 d-flex align-items-center justify-content-center">
                                <div class="col-md-1 align-items-center justify-content-center soal_${index}">
                                    <input type="checkbox" style="margin: 0;" onclick="pilihanGandaOpsiMaxTwoChecked(${index})" value="${value}" name="${index}_kunci_jawaban[]" class="kunci-jawaban-value opsi" />
                                    <span style="font-size: 14px;">${value}</span>
                                </div>
                                <div class="col-md-11">
                                    <textarea class="form-control mb-2 summernote" name="${index}_opsi_jawaban[]" cols="3" rows="3"></textarea>
                                </div>
                            </div>`;
                    });
                    opsi = `
                        <div class="pilihan-ganda-opsi">
                            ${content}
                        </div>
                    `;
                    appendAreaOpsi.find('.opsi-jawaban').html(opsi);
                    break;
                case '2':
                    // mencocokan
                    appendAreaOpsi.find('.opsi-jawaban').append(
                        `
                            <div class="d-flex justify-content-center">
                                <div class="col-md-4 text-center mb-2 mx-auto">
                                    <textarea class="form-control mb-2" name="${index}_judul_kiri" placeholder="Judul" style="height: 12px;" required></textarea>
                                </div>
                                <div class="col-md-2 text-center mb-2 mx-auto">
                                    <p class="mb-2">Jawaban</p>
                                </div>
                                <div class="col-md-4 text-center mb-2 mx-auto">
                                    <textarea class="form-control mb-2" name="${index}_judul_kanan" placeholder="Judul" style="height: 12px;" required></textarea>
                                </div>
                            </div>
                        `
                    );
                    appendAreaOpsi.find('.opsi-jawaban').append(
                        `
                        <div class='d-flex mt-3 mb-2'>
                            <div class='col-md-4 opsi-kiri'>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">1</span>
                                    </div>
                                    <textarea class="form-control mb-2" name="${index}_opsi_jawaban_kiri[]" style="height: 12px;" required></textarea>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2">2</span>
                                    </div>
                                    <textarea class="form-control mb-2" name="${index}_opsi_jawaban_kiri[]" style="height: 12px;" required></textarea>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon3">3</span>
                                    </div>
                                    <textarea class="form-control mb-2" name="${index}_opsi_jawaban_kiri[]" style="height: 12px;" required></textarea>
                                </div>

                            </div>

                            <div class="col-md-2 jawaban mx-auto">
                                <div class="mb-3">
                                    <input class="form-control" name="${index}_kunci_jawaban[]">
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" name="${index}_kunci_jawaban[]">
                                </div>
                                <div class="mb-3">
                                    <input class="form-control" name="${index}_kunci_jawaban[]">
                                </div>
                            </div>

                            <div class='col-md-4 opsi-kanan ms-2'>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon4">1</span>
                                    </div>
                                    <textarea class="form-control mb-2" name="${index}_opsi_jawaban_kanan[]" style="height: 12px;" required></textarea>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">2</span>
                                    </div>
                                    <textarea class="form-control mb-2" name="${index}_opsi_jawaban_kanan[]" style="height: 12px;" required></textarea>
                                </div>
                            
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon6">3</span>
                                    </div>
                                    <textarea class="form-control mb-2" name="${index}_opsi_jawaban_kanan[]" style="height: 12px;" required></textarea>
                                </div>
                            
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon7">4</span>
                                    </div>
                                    <textarea class="form-control mb-2" name="${index}_opsi_jawaban_kanan[]" style="height: 12px;" required></textarea>
                                </div>

                            </div>
                        <div>
                        `
                    );
                    
                    break;
                case '3':
                    // salah benar
                    opsi += `
                        <div class="opsi-remove mb-2 d-flex">
                            <div class="col-md-8 me-2">
                                <textarea class="form-control mb-2" name="${index}_opsi_jawaban[]" required></textarea>
                            </div>
                            <div class="col-md opsi-benar-salah_${index} baris-1">
                                <input type="checkbox" onchange="benarSalahOpsiChecked('benar', '1')" value="benar" class="opsi opsi-benar" name="${index}_kunci_jawaban[]" /> Benar
                                <input type="checkbox" onchange="benarSalahOpsiChecked('salah', '1')" value="salah" class="opsi opsi-salah" name="${index}_kunci_jawaban[]" /> Salah
                            </div>
                        </div>
                    `;
                    appendAreaOpsi.find('.opsi-jawaban').html(opsi);
                    appendAreaOpsi.find('.btn-add-remove-opsi').removeClass('d-none');
                    appendAreaOpsi.find('.btn-add-remove-opsi').find('.judul-benar-salah').html(`
                        <div class="d-flex justify-content-center mt-3 mb-2">
                            <div class="col-md-6 text-center mb-2 mx-auto">
                                <textarea class="form-control mb-2" name="${index}_judul" placeholder="Judul" style="height: 12px;" required></textarea>
                            </div>
                        </div>
                    `);
                    break;
                case '4':
                    // isian singkat
                    appendAreaOpsi.find('.isian-singkat').removeClass('d-none');
                    break;
                case '5':
                    // essay
                    opsi += `
                        <div class="opsi-remove mb-3 col-md-12">
                            <textarea class="form-control mb-2" name="${index}_opsi_jawaban[]" cols="3" rows="3" required></textarea>
                        </div>`;
                    break;
                default:
                    break;
            }

            summernote();
        }

        // pilihan ganda , max checked opsi = 2
        function pilihanGandaOpsiMaxTwoChecked(nomor)
        {
            var checkboxes = $(`.pilihan-ganda-opsi .soal_${nomor}`).find('input[type="checkbox"]');
            checkboxes.on('change', function() {
                var checkedCount = $(`.pilihan-ganda-opsi .soal_${nomor}`).find('input[type="checkbox"]:checked').length;

                if ($(this).prop('checked') && checkedCount > 2) {
                    $(this).prop('checked', false)
                } 
            });

        }

        // benar salah
        function benarSalahOpsiChecked(value, baris)
        {
            var index = getIndexCurrentNavlinkActive();
            var element = $(`.opsi-benar-salah_${index}.baris-${baris}`);
            console.log(baris, element);
            
            if (value == 'benar') {
                element.find('.opsi-salah').prop('checked', false)
            } else {
                element.find('.opsi-benar').prop('checked', false)
            }
        }
    
    // summernote 
        function summernote() {
            $('.summernote').summernote({
                tabsize: 2,
                height: 120,
                toolbar: [
                    // ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic']],
                    // ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['table', ['table']],
                    ['insert', ['picture']],
                    // ['view', ['fullscreen', 'codeview', 'help']]
                ],
            });
        }

        function stimulusSummernote() {
            $('.stimulus-summernote').summernote({
                tabsize: 2,
                height: 120,
                toolbar: [
                    // ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic']],
                    // ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['table', ['table']],
                    // ['insert', ['picture']],
                    // ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }

        function feedbackSummernote()
        {
            $('.feedback-summernote').summernote({
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['insert', ['picture']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ]
            });
        }

        $(function() {
            summernote();
            stimulusSummernote();
            feedbackSummernote();
        });
    </script>
    
@endpush