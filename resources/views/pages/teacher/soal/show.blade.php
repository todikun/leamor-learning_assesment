@extends('layouts.app')

@section('title', 'Soal')

@section('content')

<form action="{{route('soal.finish')}}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="soal_id" value="{{$soal->id}}" />

    <div class="row mb-3">
        <div class="col-md-4 alert alert-success ">
            <h4>Proyek <strong>{{$soal->Proyek->nama}}</h4>
            <h5>Topik <strong>{{$soal->nama}}</h5>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col-md-1">
            <div class="d-inline">
                {{-- <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex mb-3">
                                <div class="col-md">
                                    <span class="mb-3 me-1">Identitas Siswa</span>
                                    <a href="javascript:;" id="btnStimulusAdda" class=" me-3 bg-success text-white rounded-circle position-absolute">
                                        <i class="align-middle p-1" data-feather="plus"></i> 
                                    </a>
                                    <span class="mx-3"></span>
                                    <a href="javascript:;" id="btnStimulusRemovea" class=" bg-danger text-white rounded-circle position-absolute">
                                        <i class="align-middle p-1" data-feather="trash"></i> 
                                    </a>
                                </div>
                            </div>
                            
                            <input type="text" name="pernyataan[]" class="form-control mb-3" placeholder="Misalkan nama, nisn, kelas" required />
                            <div class="appendArea">

                            </div>
                        </div>
                    </div>
                </div>  --}}

                <div class="col-md-12">
                    <h3 class="mb-2">Soal</h3>
                    <div class="col-md-6 mb-3">
                        <a href="javascript:;" id="btnSoalAdd" class=" me-3 bg-success text-white rounded-circle position-absolute">
                            <i class="align-middle p-1" data-feather="plus"></i> 
                        </a>
                        <span class="mx-3"></span>
                        <a href="javascript:;" id="btnSoalRemove" class=" bg-danger text-white rounded-circle position-absolute">
                            <i class="align-middle p-1" data-feather="trash"></i> 
                        </a>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3 cek-nav-link" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                          <button class="nav-link active" onclick="setNilaiIndex(this)" id="v-pills-soal_1-tab" data-index="1" data-bs-toggle="pill" data-bs-target="#v-pills-soal_1" type="button" role="tab" aria-controls="v-pills-soal_1" aria-selected="true">1</button>

                        </div>
                    </div>
                      
                </div>
        
            </div>
        </div>

        
        <div class="col-md-11">
            
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-soal_1" role="tabpanel" aria-labelledby="v-pills-soal_1-tab">
                    <div class="row d-flex">
                        <div class="col-md-6">

                            {{-- detail soal --}}
                            {{-- <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md">
                                                <h5 class="card-title my-3">Topik <span class="text-danger">*</span></h5>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="nama[]" placeholder="Misalkan Fotosintesis, Tata surya, dll" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="col-md-6">
                                                <h5 class="card-title my-3">Durasi Ujian <span class="text-danger">*</span></h5>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="waktu_ujian[]" placeholder="Misalkan 30 menit" />
                                                    <span class="input-group-text">menit</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="card-title my-3">Waktu Feedback <span class="text-danger">*</span></h5>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="waktu_feedback[]" placeholder="Misalkan 30 menit" />
                                                    <span class="input-group-text">menit</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
        
                            {{-- stimulus --}}
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex mb-3">
                                            <div class="col-md">
                                                <span class="mb-3 me-1">Stimulus <span class="text-danger">*</span></span>
                                                <a href="javascript:;" onclick="stimulusAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                    <i class="align-middle p-1" data-feather="plus"></i> 
                                                </a>
                                                <span class="mx-3"></span>
                                                <a href="javascript:;" onclick="stimulusRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                    <i class="align-middle p-1" data-feather="trash"></i> 
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
                                        <h5 class="card-title mb-2">Skor</h5>
                                        <input type="number" class="form-control mb-2" placeholder="Skor" name="skor[]" />
                                    </div>
        
                                    <hr>
        
                                    <div class="appendAreaOpsi_1">
                                        <div class="row d-flex mb-3">
                                            <div class="col-md">
                                                <span class="mb-3 me-1">Opsi <span class="text-danger">*</span></span>
                                                <a href="javascript:;" onclick="opsiAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                    <i class="align-middle p-1" data-feather="plus"></i> 
                                                </a>
                                                <span class="mx-3"></span>
                                                <a href="javascript:;" onclick="opsiRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                    <i class="align-middle p-1" data-feather="trash"></i> 
                                                </a>
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
            </div>

        </div>
        
    </div>
    <button type="submit" class="btn btn-success position-sticky my-7 mx-5" style="float: right;">
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
            console.log(globalIndex);
        }
        
        btnSoalAdd.on('click',function(){
            var navLink = tabs.find('.nav-link').last().attr('data-index'); 
            globalIndex = parseInt(navLink) + 1;
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
                                                <i class="align-middle p-1" data-feather="plus"></i> 
                                            </a>
                                            <span class="mx-3"></span>
                                            <a href="javascript:;" onclick="stimulusRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                <i class="align-middle p-1" data-feather="trash"></i> 
                                            </a>
                                        </div>
                                    </div>
                                    
        
                                    <div class="appendAreaStimulus_${globalIndex}">
        
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
                                    <h5 class="card-title mb-2">Skor</h5>
                                    <input type="number" class="form-control mb-2" placeholder="Skor" name="skor[]" />
                                </div>

                                <hr>
    
                                <div class="appendAreaOpsi_${globalIndex}">
                                    <div class="row d-flex mb-3">
                                        <div class="col-md">
                                            <span class="mb-3 me-1">Opsi <span class="text-danger">*</span></span>
                                            <a href="javascript:;" onclick="opsiAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                <i class="align-middle p-1" data-feather="plus"></i> 
                                            </a>
                                            <span class="mx-3"></span>
                                            <a href="javascript:;" onclick="opsiRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                <i class="align-middle p-1" data-feather="trash"></i> 
                                            </a>
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
            summernote();
        });

        btnSoalRemove.on('click',function(){
            var navLink = tabs.find('.nav-link'); 
            var tabPane = tabContents.find('.tab-pane'); 
            if (navLink.length > 1) {
                navLink.last().remove();
                tabPane.last().remove();
                globalIndex--;
            }
        });

    //  stimulus 
        var btnStimulusAdd = $('.btnStimulusAdd'); 
        var btnStimulusRemove = $('.btnStimulusRemove'); 

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
                        <select name="${index}_stimulus_tipe[]" class="form-control form-select stimulus-select mb-2" onchange="changeStimulus(this)" required>
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

            var textarea = $('<textarea>', {
                'name': `${index}_stimulus[]`,
                'class': 'form-control mb-2',
                'cols': '3',
                'rows': '3',
                'required': true
            });

            var fileInput = $('<input>', {
                'name': `${index}_stimulus[]`,
                'type': 'file',
                'class': 'form-control mb-2',
                'required': true
            });

            switch ($(e).val()) {
                case 'teks':
                    stimulusDiv.append(textarea);
                    break;
                case 'dokumen':
                    stimulusDiv.append(fileInput);
                    break;
                default:
                    break;
            }
        }

    //  opsi 
        var btnOpsiAdd = $('.btnOpsiAdd'); 
        var btnOpsiRemove = $('.btnOpsiRemove'); 
        var opsi = '';
        
        function opsiAdd(e) {
            var index = getIndexCurrentNavlinkActive();
            var tipeSoal = $(`.tipe-soal_${index}`);
            var appendAreaOpsi = $(`.appendAreaOpsi_${index}`).find('.opsi-jawaban');
            
            if (tipeSoal.val() == '') {
                alert('Pilih Tipe Soal terlebih dahulu!');
                tipeSoal.focus();
                if (appendAreaOpsi.children().length > 0) {
                    appendAreaOpsi.children().remove();   
                }
            } else {
                appendAreaOpsi.append(opsi);
                var value  = appendAreaOpsi.children().length;
                appendAreaOpsi.find('.opsi-remove .kunci-jawaban-value').last().val(value)
                summernote();
            }
        }

        function opsiRemove(e) {
            var index = getIndexCurrentNavlinkActive();
            var appendAreaOpsi = $(`.appendAreaOpsi_${index}`).find('.opsi-jawaban .opsi-remove');
            if (appendAreaOpsi.length > 0) {
                appendAreaOpsi.last().remove();
            }
        }

        function changeOpsi(e)
        {
            var index = getIndexCurrentNavlinkActive();
            switch ($(e).val()) {
                case '1':
                    // pilihan ganda
                    opsi = 
                    `
                    <div class="opsi-remove mb-3 d-flex align-items-center justify-content-center">
                        <div class="col-md-10">
                            <textarea class="form-control mb-2 summernote" name="${index}_opsi_jawaban[]" cols="3" rows="3" required></textarea>
                        </div>
                        <div class="col-md ms-3">
                            <input type="radio" name="${index}_kunci_jawaban[]" class="kunci-jawaban-value" required />
                        </div>
                    </div>
                    `;
                    break;
                case '2':
                    // mencocokan
                    alert('coming soon!');
                    break;
                case '3':
                    // salah benar
                    alert('coming soon!');
                    break;
                case '4':
                    // isian singkat
                    alert('coming soon!');
                    break;
                case '5':
                    // essay
                    alert('coming soon!');
                    break;
                default:
                    opsi = '';
                    break;
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
                    // ['para', ['ul', 'ol', 'paragraph']],
                    // ['table', ['table']],
                    ['insert', ['picture']],
                    // ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }

        $(function() {
            summernote();
        });
    </script>
    
@endpush