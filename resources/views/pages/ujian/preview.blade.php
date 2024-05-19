@extends('layouts.app')

@section('title', 'Ujian')

@section('content')

<form id="formSoal" action="{{route('soal.nilai', $soal->id)}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="row mb-3 justify-content-center">
        <div class="col-md-4 alert alert-success ">
            <h2 class="text-center my-3 fw-bold" id="waktuMundur">{{$soal->waktu_ujian}} menit 0 detik</h2>
            <h5>Topik <strong>{{$soal->nama}}</h5>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col-md-2">

                {{-- <h3 class="mb-2">Soal</h3>
                <div class="col-md-6 mb-3">
                    <a href="javascript:;" id="btnSoalAdd" class=" me-3 bg-success text-white rounded-circle position-absolute">
                        <i class="align-middle p-1" data-feather="plus"></i> 
                    </a>
                    <span class="mx-3"></span>
                    <a href="javascript:;" id="btnSoalRemove" class=" bg-danger text-white rounded-circle position-absolute">
                        <i class="align-middle p-1" data-feather="trash"></i> 
                    </a>
                </div> --}}

                <div class="nav flex-row nav-pills" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
                    @foreach ($soal->SoalDetail as $item)
                        <button style="width: 1.5rem; background-color: rgb(223, 232, 240)" class="nav-link cek-nav m-1 d-flex justify-content-center align-items-center {{$loop->iteration == 1 ? 'active':''}}" id="v-pills-soal_{{$loop->iteration}}-tab" data-index="{{$loop->iteration}}" data-bs-toggle="pill" data-bs-target="#v-pills-soal_{{$loop->iteration}}" type="button" role="tab" aria-controls="v-pills-soal_{{$loop->iteration}}" aria-selected="true">
                            <span class="text-center">{{$loop->iteration}}</span>
                        </button>
                    @endforeach
                </div>
        
        </div>

        
        <div class="col-md-10">
            
            <div class="tab-content" id="v-pills-tabContent">
                @foreach ($soal->SoalDetail as $key => $item)
                    <div class="tab-pane fade show {{$loop->iteration == 1 ? 'active':''}}" id="v-pills-soal_{{$loop->iteration}}" role="tabpanel" aria-labelledby="v-pills-soal_{{$loop->iteration}}-tab">
                        <div class="row d-flex">
                            <div class="col-md-6">
            
                                {{-- stimulus --}}
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row d-flex mb-3">
                                                <div class="col-md">
                                                    <span class="mb-3 me-1">Stimulus</span>
                                                </div>
                                            </div>
                                            
                                            @foreach ($item->stimulus as $stimulus)
                                                <div class="appendAreaStimulus_{{$key+1}}">
                                                    
                                                    <div class="row d-flex stimulus-container mb-2">
                                                        {{-- <div class="col-md-4">
                                                            <select class="form-control form-select stimulus-select mb-2" onchange="changeStimulus(this)" required>
                                                                <option value="">-- PILIH --</option>
                                                                <option {{$stimulus['tipe'] == 'teks' ? 'selected':''}} value="teks">Teks</option>
                                                                <option {{$stimulus['tipe'] == 'dokumen' ? 'selected':''}} value="dokumen">Dokumen</option>
                                                            </select>
                                                        </div> --}}
                                                        <div class="col-md stimulus-tipe">
                                                            @php
                                                                $audio = ['mp3'];
                                                                $video = ['mp4'];
                                                                $image  = ['png', 'jpg', 'jpeg'];
                                                                $extension = explode('.', $stimulus['value']);
                                                            @endphp
                                                            @if ($stimulus['tipe'] == 'teks')
                                                                <textarea class="form-control mb-2" cols="3" rows="3" required>{{$stimulus['value']}}</textarea>
                                                            @else
                                                            <li>
                                                                @if (in_array($extension[1], $audio))
                                                                    <div class="row-cols-auto d-flex justify-content-center">
                                                                        <button type="button" data-id="audio{{$key+1}}"
                                                                            class="btn btn-primary btn-rewind btn-xs mb-0 ms-1"><i
                                                                                class="fa fa-backward"></i></button>
                                                                        <button type="button"
                                                                            data-action="{{asset('uploads/'.$stimulus['value'])}}"
                                                                            data-id="audio{{$key+1}}"
                                                                            class="btn btn-primary btn-play btn-xs mb-0 ms-1"><i
                                                                                class="fa fa-play"></i></button>
                                                                        <button type="button"
                                                                            data-action="{{asset('uploads/'.$stimulus['value'])}}"
                                                                            data-id="audio{{$key+1}}"
                                                                            class="btn btn-primary btn-pause btn-xs mb-0 ms-1"><i
                                                                                class="fa fa-stop"></i></button>
                                                                        <button type="button" data-id="audio{{$key+1}}"
                                                                            class="btn btn-primary btn-forward btn-xs mb-0 ms-1"><i
                                                                                class="fa fa-forward"></i></button>
                                                                        <span data-id="audio{{$key+1}}"
                                                                            class="play-status" style="font-size: 6.5pt;"></span>
                                                                    </div>
                                                                @endif
                                                                @if (in_array($extension[1], $video))
                                                                    <div class="justify-content-center">
                                                                        <button type="button" class="btn btn-secondary btn-xs my-1 btn-show" data-value="{{$stimulus['value']}}" data-jenis="Video">Show</button>
                                                                    </div>
                                                                @endif
                                                                @if (in_array($extension[1], $image))
                                                                    <div class="justify-content-center">
                                                                        <button type="button" class="btn btn-secondary btn-xs my-1 btn-show" data-value="{{$stimulus['value']}}" data-jenis="Image">Show</button>
                                                                    </div>
                                                                @endif
                                                            </li>
                                                            @endif
                                                        </div>
                                                    </div>
            
                                                </div>
                                            @endforeach
                        
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                    
                            {{-- opsi --}}
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
            
                                        <div class="form-group mb-2">
                                            <h5 class="card-title mb-2">Pertanyaan </h5>
                                            <textarea class="summernote">{{$item->pertanyaan}}</textarea>
                                        </div>
        
                                        <hr>
            
                                        <div class="appendAreaOpsi_{{$key+1}}">
                                            <div class="row d-flex mb-3">
                                                <div class="col-md">
                                                    <span class="mb-3 me-1">Opsi </span>
                                                </div>
                                            </div>
                                            <div class="col-md opsi-jawaban" >
                                                @foreach ($item->opsi_jawaban as $j => $jawaban)
                                                    <div class="opsi-remove mb-3 d-flex align-items-center justify-content-center">
                                                        <div class="col-md-10">
                                                            <textarea class="form-control mb-2 summernote" cols="3" rows="3" required>{{$jawaban}}</textarea>
                                                        </div>
                                                        <div class="col-md ms-3">
                                                            <input type="radio" value="{{$j+1}}" name="no_{{$key+1}}" required />
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
                
            </div>

        </div>
        
    </div>
    <button type="submit" class="form-control btn btn-success btn-lg position-sticky my-3 mx-1" style="float: right;">
        SUBMIT
    </button>
    

</form>
@endsection

@push('css')
    <style>      
        @keyframes zoomIn {
            0% {
                transform: scale(0.5);
            }
            100% {
                transform: scale(1);
            }
        }
        @keyframes zoomOut {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(0.5);
            }
        }

        .zoom-in-out {
            width: auto;
            height: auto;
            animation: zoomIn 1.5s alternate infinite; 
        }

    </style>
@endpush

@push('script')
    <script> 
        var myModal = $('#modal-form');
        var modalReminder = $('#modal-reminder');

        $(document).ready(function(){
            $('.cek-nav.active').css('background-color', 'blue');
            $('.cek-nav.active span').css('color', 'white');
            $('.cek-nav:not(.active) span').css('color', 'black');
            
            $('.cek-nav').click(function(){
                $('.cek-nav').css('background-color', 'rgb(223, 232, 240)');
                $('.cek-nav span').css('color', 'black');

                if($(this).hasClass('active')) {
                    $(this).css('background-color', 'blue');
                    $(this).find('span').css('color', 'white');
                } 
            });

            modalReminder.find('.modal-title').html('Reminder');
            modalReminder.find('.modal-body').html('<p>Perhatikan Soal dengan seksama, dan jawab dengan teliti!</p>');
            modalReminder.modal('show');
            
            var detik = 0;
            var menit = "{{$soal->waktu_ujian}}" ?? 20;
            // var menit = 1;
            function hitung() {
                setTimeout(hitung, 1000);
                $('#waktuMundur').html(menit + ' menit ' + detik + ' detik ');
     
                if (menit === 5 && detik === 0) {
                    $('#waktuMundur').addClass('text-danger');
                    $('#waktuMundur').addClass('zoom-in-out');
                }
     
                detik--;
                if (detik < 0) {
                    detik = 59;
                    menit--;
                    if (menit < 0) {
                        menit = 0;
                        detik = 0;
                        setInterval(function () {
                            $('#waktuMundur').html('Waktu habis!');
                            $('#formSoal').submit();
                        }, 1000);
                    }
                }
            }

            modalReminder.on('hidden.bs.modal', function(){
                hitung();
            });
        });


        var btnPlay = document.querySelectorAll('.btn-play');
        var btnPause = document.querySelectorAll('.btn-pause');
        var btnForward = document.querySelectorAll('.btn-forward');
        var btnRewind = document.querySelectorAll('.btn-rewind');
        var btnNavigasi = document.querySelectorAll('.btn-navigasi');
        var noUrut = document.getElementById('no-urut');
        var playStatus = document.querySelectorAll('.play-status');
        var activeAudios = {};

        btnPlay.forEach(function(button){
            button.addEventListener('click', function(e){
                e.preventDefault();
                let url = this.dataset.action;
                let id = this.dataset.id;
                // Menghentikan audio yang sedang diputar sebelumnya
                for (let audioId in activeAudios) {
                    activeAudios[audioId].pause();
                    activeAudios[audioId].currentTime = 0;
                }

                activeAudios[id] = new Audio(url);
                activeAudios[id].play();

                playStatus.forEach(function(status){
                    // show status
                    if (status.dataset.id == id) {
                        console.log('status play');
                        status.innerHTML = 'play';
                    } else {
                        status.innerHTML = '';
                    }
                });
                console.log("play ",activeAudios);

            });
        });
        
        btnPause.forEach(function(button){
            button.addEventListener('click', function(e){
                e.preventDefault();
                let url = this.dataset.action;
                let id = this.dataset.id;
                
                if (activeAudios[id]) {
                    activeAudios[id].pause();
                    activeAudios[id].currentTime = 0;
                    console.log('stop ',activeAudios);
                    delete activeAudios[id];
                }

                // delete status
                playStatus.forEach(function(status){
                    if (status.dataset.id == id) {
                        status.innerHTML = '';
                    }
                });
            });
        });
        
        btnForward.forEach(function(button){
            button.addEventListener('click', function(e){
                e.preventDefault();
                let id = this.dataset.id;
                if (activeAudios[id]) {
                    activeAudios[id].currentTime += 5;
                    console.log('forward 5s ', activeAudios);
                }
            });
        });
        
        btnRewind.forEach(function(button){
            button.addEventListener('click', function(e){
                e.preventDefault();
                let id = this.dataset.id;
                if (activeAudios[id]) {
                    activeAudios[id].currentTime -= 5;
                    console.log('rewind 5s ', activeAudios);
                }
            });            
        });

        $('.btn-show').on('click',function(){
            var jenisDokumen = $(this).attr('data-jenis');
            var dokumen = 'uploads/' + $(this).attr('data-value');
            var html = ''
            if (jenisDokumen == 'Video') {
                html = `
                <video controls width="100%" id="videoStimulus" height="auto">
                    <source src="${dokumen}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                `;
            }
            if (jenisDokumen == 'Image') {
                html = `
                <img src=${dokumen} class="rounded" width="100 height="auto />
                `;
            }
            myModal.find('.modal-title').html(jenisDokumen);
            myModal.find('.modal-body').html(html);
            myModal.modal('show');
        });

        myModal.on('hidden.bs.modal', function(){
            var video = document.getElementById("videoStimulus");
            video.pause(); // Hentikan video
        });

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
    </script>
@endpush