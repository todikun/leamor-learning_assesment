<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{env('APP_NAME')}}</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .svg-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            background-color: none;
            /* background-color: #f8f9fa; */
        }
        .svg-content {
            width: 300px;
            height: 150px;
        }
        .title {
            font-size: 10px;
            font-weight: bold;
            text-anchor: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="row justify-content-md-center text-center d-flex">

                @include('components.alert')
                <div class="pb-3 mb-5">
                    <div class="svg-container">
                        <svg class="svg-content" viewBox="0 0 100 50">
                            <path id="curve" d="M10,40 A40,20 0 0,1 90,40" fill="transparent"/>
                            <text class="title">
                                <textPath href="#curve" startOffset="50%">
                                    Selamat Datang
                                </textPath>
                            </text>
                        </svg>
                    </div>
                    {{-- <span>As</span>  --}}
                </div>

                <div class="col-md-6">
                    <a href="{{route('login', ['q'=>'teacher'])}}" class="btn-login">
                        <div style="border: none; background-color: #79dfc1;;" class="card card-body d-flex align-items-center justify-content-center">
                            <img src="{{asset('dist/img/teacher.png')}}" alt="err" width="150px" height="150px" />
                        </div>
                    </a>
                    <p class="text-center mt-3">Guru</p>
                </div>
                
                <div class="col-md-6">
                    <a href="{{route('login', ['q'=>'student'])}}" class="btn-login">
                        <div style="border: none; background-color: #79dfc1;" class="card card-body d-flex align-items-center justify-content-center">
                            <img src="{{asset('dist/img/student.png')}}" alt="err" width="150px" height="150px" />
                        </div>
                    </a>
                    <p class="text-center mt-3">Siswa</p>
                </div>
              </div>
          </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>

    <script>
        $('.btn-login').on('click', function(){
            e.preventDefault();
            var url = $(this).attr('href');

            $.ajax({
                url: url,
                dataType: 'HTML',
                method: 'GET',
                success: function (result) {
                    $('#modal-form').find('#modal-label').html('Edit Gejala');
                    $('#modal-form').find('.modal-body').html(result);
                    $('#modal-form').modal('show');
                },
                error: function (err) {
                    console.log(err);
                },
            });
        });
    </script>
</body>
</html>