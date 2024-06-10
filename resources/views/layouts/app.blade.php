<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    {{-- <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('dist/landing/assets/img/icons/logo-padang.png') }}"> --}}

    <title>@yield('title') | Leamor</title>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
    <link href="{{ asset('dist/css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    
    @stack('css')
</head>

<body>
    <div class="wrapper">

        <!-- Sidebar Start-->
        @include('components.sidebar')
        <!-- Sidebar End-->

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <!-- Navbar Start-->
                @include('components.navbar')
                <!-- Navbar End-->
            </nav>

            <!-- Main content -->
            <main class="content">
                <div class="container-fluid p-0">
                    @include('components.alert')
                    @yield('content')
                </div>
            </main>
            <!-- Main content -->
            <div class="modal fade" id="modal-reminder" tabindex="-1" aria-labelledby="panoramaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" ></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button class="form-control btn btn-primary btn-lg" data-bs-dismiss="modal" aria-label="Close">Mulai Ujian</button>
                    </div>
                  </div>
                </div>
            </div>
            
            <!-- Modal content start -->
            <div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="panoramaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" ></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                  </div>
                </div>
              </div>
            <!-- Modal content end -->

            <!-- Footer Start-->
            @include('components.footer')
            <!-- Footer End-->
        </div>
    </div>
    

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#modal-form').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#modal-reminder').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        var navbar = $('.hamburger');
        var sessionUjian = "{{$ujian ?? false}}";
        if (sessionUjian == true) {
            navbar.addClass('d-none')
        }

        // toast options
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "2500",
            "timeOut": "1500",
            "extendedTimeOut": "5000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>

    <script>
        var myModal = $('#modal-form');

        function previewStimulus(e)
        {
            var url = e.dataset.url;
            var value = e.dataset.value;
            
            var baseUrl = "{{env('APP_URL')}}";
            var dokumen = baseUrl + url;

            var html = ''
            var jenisDokumen = value.split('.');

            var video = ['mp4'];
            if (video.includes(jenisDokumen[1])) {
                html = `
                <video controls width="100%" height="auto">
                    <source src="${dokumen}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                `;
            }

            var gambar = ['jpg', 'jpeg', 'png']
            if (gambar.includes(jenisDokumen[1])) {
                html = `
                <img src=${dokumen} class="rounded" width="450px height="auto />
                `;
            }

            var audio = ['mp3'];
            if (audio.includes(jenisDokumen[1])) {
                html = `
                    <audio controls>
                        <source src="${dokumen}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                `;
            }

            myModal.find('.modal-title').html(jenisDokumen[0]);
            myModal.find('.modal-body').html(html);
            myModal.modal('show');
        }
        
        myModal.on('show.bs.modal', function(){
            stopMediaPlayer()
        });

        myModal.on('hidden.bs.modal', function(){
            stopMediaPlayer();
        });


        function stopMediaPlayer() {
            var video = $("video");
            var audio = $("audio");
            if (video.length) {
                video.each(function() {
                    this.pause();
                    this.currentTime = 0;
                });
            }

            if (audio.length) {
                audio.each(function() {
                    this.pause();
                    this.currentTime = 0; 
                });
            }
        }

        function modalForm(data, title, size = 'modal-lg')
        {
            $('#modal-form').find('.modal-title').html(title);
            $('#modal-form').find('.modal-dialog').addClass(size);
            $('#modal-form').find('.modal-body').html(data);
            $('#modal-form').modal('show');
        }

    </script>

    @stack('script')

</body>

</html>
