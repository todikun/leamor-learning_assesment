@extends('layouts.app')

@section('title', 'Soal')

@section('content')

<form action="{{route('soal.create_update')}}" method="post" enctype="multipart/form-data">
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
                                                                    <textarea name="{{$key+1}}_stimulus[]" class="form-control mb-2 text-stimulus" cols="3" rows="3" required="required">{{$stimulus['value']}}</textarea>
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
                                                <h5 class="card-title mb-2">Skor</h5>
                                                <input type="number" class="form-control mb-2" value="{{$item->skor}}" placeholder="Skor" name="skor[]" required/>
                                            </div>
                
                                            <hr>
                
                                            <div class="appendAreaOpsi_{{$key+1}}">
                                                <div class="row d-flex mb-3">
                                                    <div class="col-md">
                                                        <span class="mb-3 me-1">Opsi <span class="text-danger">*</span></span>
                                                        {{-- <a href="javascript:;" onclick="opsiAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                            <i class="fa fa-plus p-2"></i> 
                                                        </a>
                                                        <span class="mx-3"></span>
                                                        <a href="javascript:;" onclick="opsiRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                            <i class="fa fa-times p-2"></i> 
                                                        </a> --}}
                                                    </div>
                                                </div>
                                                <div class="col-md opsi-jawaban" >
                                                    @foreach ($item->opsi_jawaban as $j => $jawaban)
                                                        <div class="opsi-remove mb-3 d-flex align-items-center justify-content-center">
                                                            <div class="col-md-10">
                                                                <textarea class="form-control mb-2 summernote" name="{{$key+1}}_opsi_jawaban[]" cols="3" rows="3" required>{{$jawaban}}</textarea>
                                                            </div>
                                                            <div class="col-md ms-3">
                                                                <input type="radio" {{$j+1 == $item->kunci_jawaban ? 'checked':''}} value="{{$j+1}}"  name="{{$key+1}}_kunci_jawaban[]" class="kunci-jawaban-value" required />
                                                            </div>
                                                        </div>
                                                    @endforeach
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
                                            <h5 class="card-title mb-2">Skor</h5>
                                            <input type="number" class="form-control mb-2" placeholder="Skor" name="skor[]" required />
                                        </div>
            
                                        <hr>
            
                                        <div class="appendAreaOpsi_1">
                                            <div class="row d-flex mb-3">
                                                <div class="col-md">
                                                    <span class="mb-3 me-1">Opsi <span class="text-danger">*</span></span>
                                                    {{-- <a href="javascript:;" onclick="opsiAdd(this)" class="me-3 bg-success text-white rounded-circle position-absolute">
                                                        <i class="fa fa-plus p-2"></i> 
                                                    </a>
                                                    <span class="mx-3"></span>
                                                    <a href="javascript:;" onclick="opsiRemove(this)" class="bg-danger text-white rounded-circle position-absolute">
                                                        <i class="fa fa-times p-2"></i> 
                                                    </a> --}}
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
    <button type="submit" class="btn btn-lg btn-success position-sticky my-7 mx-5" style="float: right;">
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
                                    <h5 class="card-title mb-2">Skor</h5>
                                    <input type="number" class="form-control mb-2" placeholder="Skor" name="skor[]" required/>
                                </div>

                                <hr>
    
                                <div class="appendAreaOpsi_${globalIndex}">
                                    <div class="row d-flex mb-3">
                                        <div class="col-md">
                                            <span class="mb-3 me-1">Opsi <span class="text-danger">*</span></span>
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

            // re-init summernote
            summernote();
            feedbackSummernote();
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
                <textarea name="${index}_stimulus[]" class="form-control mb-2 text-stimulus" cols="3" rows="3" required></textarea>
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
        // var btnOpsiAdd = $('.btnOpsiAdd'); 
        // var btnOpsiRemove = $('.btnOpsiRemove'); 
        // var opsi = '';
        
        // function opsiAdd(e) {
        //     var index = getIndexCurrentNavlinkActive();
        //     var tipeSoal = $(`.tipe-soal_${index}`);
        //     var appendAreaOpsi = $(`.appendAreaOpsi_${index}`).find('.opsi-jawaban');
            
        //     if (tipeSoal.val() == '') {
        //         alert('Pilih Tipe Soal terlebih dahulu!');
        //         tipeSoal.focus();
        //         if (appendAreaOpsi.children().length > 0) {
        //             appendAreaOpsi.children().remove();   
        //         }
        //     } else if (tipeSoal.val() == '3') {
        //         return;
        //     } else {
        //         opsi == '' ? changeOpsi(tipeSoal.val()) : null;
        //         appendAreaOpsi.append(opsi);
        //         var value  = appendAreaOpsi.children().length;
        //         appendAreaOpsi.find('.opsi-remove .kunci-jawaban-value').last().val(value)
        //         summernote();
        //     }
        // }

        // function opsiRemove(e) {
        //     var index = getIndexCurrentNavlinkActive();
        //     var appendAreaOpsi = $(`.appendAreaOpsi_${index}`).find('.opsi-jawaban .opsi-remove');
        //     var tipeSoal = $(`.tipe-soal_${index}`);
           
        //     if (tipeSoal.val() != '3' && appendAreaOpsi.length > 0) {
        //         appendAreaOpsi.last().remove();
        //     }
        // }

        function changeOpsi(e)
        {
            var index = getIndexCurrentNavlinkActive();
            var appendAreaOpsi = $(`.appendAreaOpsi_${index}`).find('.opsi-jawaban');
            var opsi = '';

            switch ($(e).val() ?? e) {
                case '1':
                    // pilihan ganda
                    var pilihan = ['a','b','c','d'];
                    pilihan.forEach(value => {
                        opsi += `
                            <div class="opsi-remove mb-3 d-flex align-items-center justify-content-center">
                                <div class="col-md-10">
                                    <textarea class="form-control mb-2 summernote" name="${index}_opsi_jawaban[]" cols="3" rows="3" required></textarea>
                                </div>
                                <div class="col-md ms-3">
                                    <input type="radio" value="${value}" name="${index}_kunci_jawaban[]" class="kunci-jawaban-value" required />
                                </div>
                            </div>`;
                    });
                    break;
                case '2':
                    // mencocokan
                    alert('coming soon!');
                    break;
                case '3':
                    // salah benar
                    var index = getIndexCurrentNavlinkActive();
                    var tipeSoal = $(`.tipe-soal_${index}`);
                    var appendAreaOpsi = $(`.appendAreaOpsi_${index}`).find('.opsi-jawaban');
            
                    opsi = 
                    `
                    <div class="opsi-remove mb-3 d-flex align-items-center justify-content-center">
                        <div class="col-md ms-3">
                            <input type="hidden" value="benar" name="${index}_opsi_jawaban[]" />
                            <input type="radio" name="${index}_kunci_jawaban[]" class="kunci-jawaban-value" value="benar" /> benar
                        </div>
                        <div class="col-md ms-3">
                            <input type="hidden" value="salah" name="${index}_opsi_jawaban[]" />
                            <input type="radio" name="${index}_kunci_jawaban[]" class="kunci-jawaban-value" value="salah" /> salah
                        </div>
                    </div>
                    `;
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
                    break;
            }
            appendAreaOpsi.html(opsi);
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

        function feedbackSummernote()
        {
            $('.feedback-summernote').summernote({
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['insert', ['picture']],
                ]
            });
        }

        $(function() {
            summernote();
            feedbackSummernote();
        });
    </script>
    
@endpush