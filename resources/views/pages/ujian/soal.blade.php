@extends('layouts.app')

@section('title', 'Ujian')

@section('content')
@php
    $route = $ujian == true ? route('ujian.nilai', $soal->id) : route('soal.nilai', $soal->id);
@endphp
<form id="formSoal" action="{{$route}}" method="post" enctype="multipart/form-data">
    @csrf

    @forelse ($pernyataan as $p)
        <input type="hidden" name="pernyataan[]" value="{{$p}}" />
    @empty
        <input type="hidden" name="pernyataan[]" value="" />
    @endforelse

    <div class="justify-content-center ">
        <h3 class="text-center mb-1 fw-bold" id="waktuMundur">{{$soal->waktu_ujian}} menit 0 detik</h4>
        <p class="text-center">Topik <strong>{{$soal->nama}}</h5>
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
                                        <div class="row d-flex mb-2">
                                            <div class="col-md">
                                                <span class="me-1">Stimulus</span>
                                            </div>
                                        </div>
                                        
                                        @foreach ($item->stimulus as $stimulus)
                                            <div class="appendAreaStimulus_{{$key+1}}">
                                                
                                                <div class="row d-flex stimulus-container mb-2">
                                                    <div class="col-md stimulus-tipe">
                                                        @php
                                                            $audio = ['mp3'];
                                                            $video = ['mp4'];
                                                            $image  = ['png', 'jpg', 'jpeg'];
                                                            $extension = explode('.', $stimulus['value']);
                                                        @endphp
                                                        @if ($stimulus['tipe'] == 'teks')
                                                            <div class="mb-1 ms-2" style="font-weight: normal">
                                                                {!!$stimulus['value']!!}
                                                            </div>
                                                        @else
                                                            @if (in_array($extension[1], $audio))
                                                                <div class=" mb-1 d-flex justify-content-center align-items-center ms-2">
                                                                    <audio controls class="audio-player">
                                                                        <source src="{{asset('uploads/'.$stimulus['value'])}}" type="audio/mpeg">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                </div>
                                                            @endif
                                                            @if (in_array($extension[1], $video))
                                                                <div class="mb-1 d-flex justify-content-center align-items-center ms-2">
                                                                    <video controls width="100%" height="auto" class="audio-player">
                                                                        <source src="{{asset('uploads/' . $stimulus['value'])}}" type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                            @endif
                                                            @if (in_array($extension[1], $image))
                                                                <div class="mb-1 d-flex justify-content-center align-items-center ms-2">
                                                                    <a href="{{asset('uploads/' . $stimulus['value'])}}" target="_blank" title="Klik pada gambar untuk memperbesar">
                                                                        <img src="{{asset('uploads/' . $stimulus['value'])}}" alt="img" width="360px;" height="auto"/>
                                                                    </a>
                                                                </div>
                                                            @endif
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
                                        <div class="mb-2" style="font-weight: normal">
                                            {!!$item->pertanyaan!!}
                                        </div>
                                    </div>
        
                                    <div class="appendAreaOpsi_{{$key+1}}">
                                        <div class="col-md opsi-jawaban">
                                            @php
                                                $pilihan_ganda = ['a','b','c','d'];
                                                $tipe_soal = $item->tipe_soal_id
                                            @endphp
                                            @foreach ($item->tipe_soal_id != '2' ? $item->opsi_jawaban : $item->opsi_jawaban[0] as $j => $jawaban)
                                                @switch($item->tipe_soal_id)
                                                    @case('1')
                                                    {{-- pilihan ganda --}}
                                                        <div class="d-flex mb-2">
                                                            <input type="radio" value="{{$pilihan_ganda[$j]}}" name="no_{{$key+1}}" required />
                                                            <div class="ms-1" style="font-weight: normal">
                                                                {!!$jawaban!!}
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case('2')
                                                    {{-- mencocokan --}}
                                                    <div class="mb-3 d-flex align-items-center justify-content-center">
                                                        <div class="col-md-6">
                                                            <div class="mb-3 d-flex">
                                                                <div class="col-md-1 ms-3">
                                                                    <input type="radio" value="{{$pilihan_ganda[$j]}}" name="no_{{$key+1}}_kiri" class="kunci-jawaban-value" required />
                                                                </div>
                                                                <div class="col-md-11">
                                                                    {!!$item->opsi_jawaban[0][$j]!!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3 d-flex">
                                                                <div class="col-md-1 ms-3">
                                                                    <input type="radio" value="{{$pilihan_ganda[$j]}}" name="no_{{$key+1}}_kanan" class="kunci-jawaban-value" required />
                                                                </div>
                                                                <div class="col-md-11">
                                                                    {!!$item->opsi_jawaban[1][$j]!!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        @break
                                                    @case('3')
                                                    {{-- salah benar --}}
                                                        <input type="radio" name="no_{{$key+1}}" class="ms-3" value="{{$jawaban}}" required /> {{$jawaban}}
                                                        @break
                                                    @case('4')
                                                    {{-- isian singkat --}}
                                                        <textarea class="form-control mb-2" name="no_{{$key+1}}[]" cols="3" rows="3" required></textarea>
                                                        @break
                                                    @case('5')
                                                    {{-- essay --}}
                                                        <textarea class="form-control mb-2" name="no_{{$key+1}}" cols="3" rows="3" required></textarea>
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
    <button type="submit" onclick="return confirm('Apa kamu yakin untuk mengakhiri ujian ini?')" class="form-control btn btn-success btn-lg position-sticky my-3 mx-1" style="float: right;">
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

        $('audio, video').on('play', function() {
            stopAudioPlayer();
        });
    </script>
@endpush