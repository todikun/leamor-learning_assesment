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

    <div class="row">

        <div class="row d-flex justify-content-center">

            <div class="col-md-12 mb-3">
                <div class="nav flex-row nav-pills cek-nav-link" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
                    @foreach ($soal->SoalDetail as $item)
                        <button style="width: 1.5rem; background-color: rgb(223, 232, 240); pointer-events: none;" class="nav-link cek-nav m-1 d-flex justify-content-center align-items-center {{$loop->iteration == 1 ? 'active':''}}" data-checked="false" id="v-pills-soal_{{$loop->iteration}}-tab" data-index="{{$loop->iteration}}" data-bs-toggle="pill" data-bs-target="#v-pills-soal_{{$loop->iteration}}" type="button" role="tab" aria-controls="v-pills-soal_{{$loop->iteration}}" aria-selected="true">
                            <span class="text-center">{{$loop->iteration}}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="tab-content" id="v-pills-tabContent">
                @foreach ($soal->SoalDetail as $key => $item)
                <div class="tab-pane fade show {{$loop->iteration == 1 ? 'active':''}}" id="v-pills-soal_{{$loop->iteration}}" role="tabpanel" aria-labelledby="v-pills-soal_{{$loop->iteration}}-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row d-flex align-items-stretch">

                                <div class="col-md-5">
            
                                    {{-- stimulus --}}
                                    <div class="col-md-12">
                                        {{-- <div class="row d-flex mb-2">
                                            <div class="col-md">
                                                <span class="me-1">Stimulus</span>
                                            </div>
                                        </div> --}}
                                        
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
                                        {{-- <h5 class="card-title mb-2">Pertanyaan </h5> --}}
                                        <div class="mb-2" style="font-weight: normal">
                                            {!!$item->pertanyaan!!}
                                        </div>
                                    </div>
        
                                    <div class="appendAreaOpsi_{{$key+1}}">
                                        <div class="col-md opsi-jawaban">
                                            @php
                                                $pilihan_ganda = ['A','B','C','D'];
                                                $tipe_soal = $item->tipe_soal_id
                                            @endphp
                                            @switch($item->tipe_soal_id)
                                                @case('1')
                                                    @foreach ($item->opsi_jawaban as $j => $jawaban)
                                                    {{-- pilihan ganda --}}
                                                        <div class="pilihan-ganda-opsi d-flex align-items-center mb-2" data-nomor="{{$key+1}}">
                                                            <div class="col-md-1 d-flex align-items-center justify-content-center soal_{{$key+1}}">
                                                                <input class="opsi" type="checkbox" style="margin: 0;" value="{{$pilihan_ganda[$j]}}" name="no_{{$key+1}}[]" />
                                                                <span class="ms-1 fw-bold" style="font-size: 16px;">{{$pilihan_ganda[$j]}}.</span>
                                                            </div>
                                                            <div class="col-md d-flex">
                                                                {!!$jawaban!!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @break

                                                @case('2')
                                                {{-- mencocokan --}}

                                                    <div class="d-flex mt-3 mb-2">
                                                        <div class="col-md-4 opsi-kiri">
                                                            <table class="table table-bordered border-hijau">
                                                                <thead>
                                                                    <tr>
                                                                        <td class="text-center">{{$item->opsi_jawaban['judul']['kiri']}}</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($item->opsi_jawaban['opsi_jawaban_kiri'] as $no => $opsi)
                                                                        <tr>
                                                                            <td><strong>{{$no+1}}.</strong> {{$opsi}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="col-md-2 jawaban">
                                                            <table class="table table-bordered border-hijau">
                                                                <thead>
                                                                    <tr>
                                                                        <td class="text-center">Jawaban</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($item->kunci_jawaban as $jawaban)
                                                                        <tr>
                                                                            <td>
                                                                                <input oninput="checkInput({{$key+1}})" class="form-control kunci-jawaban-mencocokan baris-{{$key+1}}" name="no_{{$key+1}}[]">
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="col-md-4 opsi-kanan ms-5">
                                                            <table class="table table-bordered border-hijau">
                                                                <thead>
                                                                    <tr>
                                                                        <td class="text-center">{{$item->opsi_jawaban['judul']['kanan']}}</td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($item->opsi_jawaban['opsi_jawaban_kanan'] as $no => $opsi)
                                                                        <tr>
                                                                            <td><strong>{{$no+1}}.</strong> {{$opsi}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                    </div>

                                                    @break
                                                @case('3')
                                                {{-- benar salah --}}

                                                    <p class="text-center my-3">
                                                        {{$item->opsi_jawaban['judul']}}
                                                    </p>
                                                    <table class="table table-bordered border-hijau">
                                                        <tbody>
                                                            @foreach ($item->opsi_jawaban['opsi'] as $j => $jawaban)
                                                                <tr class="border-hijau opsi-benar-salah_{{$key+1}} baris-{{$j+1}}">
                                                                    <td class="border-hijau" width="70%">{{$jawaban}}</td>
                                                                    <td class="border-hijau" width="15%">
                                                                        <input type="checkbox" onchange="benarSalahOpsiChecked('benar', {{$j+1}})" value="benar" class="opsi opsi-benar" name="no_{{$key+1}}[]" /> Benar
                                                                    </td>
                                                                    <td class="border-hijau" width="15%">
                                                                        <input type="checkbox" onchange="benarSalahOpsiChecked('salah', {{$j+1}})" value="salah" class="opsi opsi-salah" name="no_{{$key+1}}[]" /> Salah
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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

    <button type="submit" onclick="return confirm('Apa kamu yakin untuk mengakhiri ujian ini?')" class="btn btn-success position-sticky my-3 mx-1 {{sizeof($soal->SoalDetail) == 1 ? '' : 'd-none'}} btn-save" style="float: right;">
        <i class="fa fa-save"></i> Selesai dan Simpan
    </button>

    <button type="button" onclick="navSoal('next')" class="nav-soal btn btn-success position-sticky my-3 mx-1 {{sizeof($soal->SoalDetail) == 1 ? 'd-none' : ''}} btn-next" style="float: right;">
        Selanjutnya <i class="fa fa-arrow-right"></i>
    </button>

    <button type="button" onclick="navSoal('previous')" class="nav-soal btn btn-success position-sticky my-3 mx-1 d-none btn-previous" style="float: right;">
        <i class="fa fa-arrow-left"></i> Sebelumnya
    </button>

</form>
@endsection

@push('css')
    <style>   
        .border-hijau {
            border: 2px solid #79dfc1;
        }

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
        var jumlahSoal = @json($soal->SoalDetail->toArray() ?? []);

        var warnaNomorTab = {};
        jumlahSoal.forEach((el, iteration) => {
            warnaNomorTab[iteration + 1] = false;
        });
        

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

        function navSoal(value) {
            var btnPrevious = $('.btn-previous');
            var btnNext = $('.btn-next');
            var btnSave = $('.btn-save');
            var currentTab = $('.nav-link.active');
            var nextTab = currentTab.next('.nav-link');
            var prevTab = currentTab.prev('.nav-link');

            var nextTabNomor = nextTab.find('span').html();
            var prevTabNomor = prevTab.find('span').html();

            if (value === 'next' && nextTab.length > 0) {
                // Pindah ke tab berikutnya
                nextTab.trigger('click');
                if (warnaNomorTab[nextTabNomor] == true) {
                    nextTab.css('background', 'linear-gradient(to bottom, #1cbb8c 100%, blue 0%)');
                } else {
                    nextTab.css('background', 'blue');
                }

                nextTab.find('span').css('color', 'white');
                prevTab.find('span').css('color', 'black');
                
                btnPrevious.removeClass('d-none');
                
                // Cek apakah sudah berada di tab terakhir, jika ya sembunyikan tombol "Selanjutnya"
                if (nextTab.is(':last-child')) {
                    btnNext.addClass('d-none');
                    btnSave.removeClass('d-none');
                }
            }

            if (value === 'previous') {
                var prevTab = currentTab.prev('.nav-link'); // Tab sebelumnya
                nextTab.find('span').css('color', 'black');

                if (prevTab.length > 0) {
                    // Pindah ke tab sebelumnya
                    prevTab.trigger('click'); // Memicu klik pada tab sebelumnya untuk memperbarui tampilan
                    if (warnaNomorTab[prevTabNomor] == true) {
                        prevTab.css('background', 'linear-gradient(to bottom, #1cbb8c 100%, blue 0%)');
                    } else {
                        prevTab.css('background', 'blue');
                    }
                    
                    prevTab.find('span').css('color', 'white');
                    nextTab.find('span').css('color', 'black');

                    btnNext.removeClass('d-none');
                    btnSave.addClass('d-none');
                }
                
                // Cek apakah sudah berada di tab pertama, jika ya sembunyikan tombol "Sebelumnya"
                if (prevTab.is(':first-child')) {
                    btnPrevious.addClass('d-none');
                }
            }

        }

        // pilihan ganda , max checked opsi = 2
        $('.pilihan-ganda-opsi').each(function() {
            var soal = $(this);
            var nomor = soal.data('nomor');
            var checkboxes = soal.find('input[type="checkbox"]');
            
            checkboxes.on('change', function() {
                var checkedCount = $(`.pilihan-ganda-opsi .soal_${nomor}`).find('input[type="checkbox"]:checked').length;
                
                if ($(this).prop('checked') && checkedCount <= 2) {
                    $('.nav-link.active').attr('data-checked', true);
                    warnaNomorTab[nomor] = true;
                }

                if ($(this).prop('checked') && checkedCount > 2) {
                    $(this).prop('checked', false);
                } 

                if (!$(this).prop('checked') && checkedCount == 0) {
                    $('.nav-link.active').attr('data-checked', false);
                    warnaNomorTab[nomor] = false;
                }

                // jika ada terjawab soal maka ada warna hijau di tab nomor soal
                ubahNomorTabSoal(nomor);
            });
        });

        function getIndexCurrentNavlinkActive() {
            var index = '';
            $('.cek-nav-link').each(function() {
                index = $(this).find('.nav-link.active').data('index');
            });
            return index;
        }
        
        // soal mencocokan -> warna tombol tab
        function checkInput(value) {
            var semuaInputTerisi = false;

            $(`.kunci-jawaban-mencocokan.baris-${value}`).each(function() {
                if ($(this).val().trim() !== "") {
                    semuaInputTerisi = true;
                }
            });

            if (semuaInputTerisi == true) {
                warnaNomorTab[value] = true
            } else {
                warnaNomorTab[value] = false
            }
            ubahNomorTabSoal(value)
            
        }
        
        // benar salah
        function benarSalahOpsiChecked(value, baris)
        {
            var index = getIndexCurrentNavlinkActive();
            var element = $(`.opsi-benar-salah_${index}.baris-${baris}`);
            var semuaElement = $(`.opsi-benar-salah_${index}`);
            var semuaInputTerisi = false;
            
            if (value == 'benar') {
                element.find('.opsi-salah').prop('checked', false)
            } else {
                element.find('.opsi-benar').prop('checked', false)
            }

            semuaElement.each(function(){
                $(this).find('.opsi').each(function(){
                    if ($(this).prop('checked') == true) {
                        semuaInputTerisi = true;
                    }
                })
            })

            if (semuaInputTerisi == true) {
                warnaNomorTab[index] = true
            } else {
                warnaNomorTab[index] = false
            }
            ubahNomorTabSoal(index)
        }

        function ubahNomorTabSoal(jawaban)
        {
            var currentTab = $('.nav-link.active');
            var warnaHijau = 'linear-gradient(to bottom, #1cbb8c 100%, blue 0%)';
            
            if (warnaNomorTab[jawaban] == true) {
                currentTab.css('background', warnaHijau);
            } else {
                currentTab.css('background', 'blue');
            }
        }
        

    </script>
@endpush