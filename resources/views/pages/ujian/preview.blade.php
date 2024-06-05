@extends('layouts.app')

@section('title', 'Ujian')

@section('content')

<form id="formSoal" action="{{route('soal.nilai', $soal->id)}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="row mb-3 justify-content-center pb-3">
        <div class="col-md-4 alert alert-success ms-auto">
            <h2 class="text-center my-3 fw-bold" id="waktuMundur">{{$soal->waktu_ujian}} menit 0 detik</h2>
            <h5>Topik <strong>{{$soal->nama}}</h5>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col-md-2">
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
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex align-items-stretch">

                                    <div class="col-md-5">
            
                                        {{-- stimulus --}}
                                        <div class="col-md-12">
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
                                                                    <div class="d-flex justify-content-center align-items-center">
                                                                        <audio controls class="audio-player">
                                                                            <source src="{{asset('uploads/'.$stimulus['value'])}}" type="audio/mpeg">
                                                                            Your browser does not support the audio element.
                                                                        </audio>
                                                                    </div>
                                                                @endif
                                                                @if (in_array($extension[1], $video))
                                                                    <div class="d-flex justify-content-center align-items-center">
                                                                        <button type="button" class="btn btn-secondary btn-xs my-1 btn-show" data-value="{{$stimulus['value']}}" data-jenis="Video">Show</button>
                                                                    </div>
                                                                @endif
                                                                @if (in_array($extension[1], $image))
                                                                    <div class="d-flex justify-content-center align-items-center">
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

                                    <div class="col-md-1 d-flex justify-content-center align-items-center">
                                        <div class="vr" style="border-left: 2px solid black;"></div>
                                    </div>

                                    {{-- opsi --}}
                                    <div class="col-md-6">
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
                                                    @switch($item->tipe_soal_id)
                                                        @case('1')
                                                        {{-- pilihan ganda --}}
                                                            <div class="opsi-remove mb-3 d-flex align-items-center justify-content-center">
                                                                <div class="col-md-10">
                                                                    <textarea class="form-control mb-2 summernote" cols="3" rows="3" required>{{$jawaban}}</textarea>
                                                                </div>
                                                                <div class="col-md ms-3">
                                                                    <input type="radio" value="{{$j+1}}" name="no_{{$key+1}}" required />
                                                                </div>
                                                            </div>
                                                            @break
                                                        @case('2')
                                                        {{-- mencocokan --}}
                                                            @break
                                                        @case('3')
                                                        {{-- salah benar --}}
                                                            <div class="opsi-remove mb-3 d-flex align-items-center justify-content-center">
                                                                <div class="col-md ms-3">
                                                                    <input type="radio" name="no_{{$key+1}}" value="{{$jawaban}}" /> {{$jawaban}}
                                                                </div>
                                                            </div>
                                                            @break
                                                        @case('4')
                                                        {{-- isian singkat --}}
                                                            @break
                                                        @case('5')
                                                        {{-- essay --}}
                                                            @break
                                                        @default
                                                            
                                                    @endswitch
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

            stopAudioPlayer();

        });

        $('.btn-show').on('click',function(){
            var jenisDokumen = $(this).attr('data-jenis');
            var baseUrl = "{{env('APP_URL')}}";
            var dokumen = baseUrl + '/uploads/' + $(this).attr('data-value');
            var html = ''
            if (jenisDokumen == 'Video') {
                html = `
                <video controls width="100%" height="auto">
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

        function stopAudioPlayer() {
            var audioPlayers = document.querySelectorAll('.audio-player');
            audioPlayers.forEach(function(player) {
                player.addEventListener('play', function() {
                    audioPlayers.forEach(function(otherPlayer) {
                        if (otherPlayer !== player) {
                            otherPlayer.pause();
                        }
                    });
                });
            });
        }

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