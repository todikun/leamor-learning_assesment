<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Leamor</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="row justify-content-md-center text-center d-flex">

                @include('components.alert')
                <div class="pb-3 mb-3">
                    <h3 class="mb-5 fw-bold">Welcome to Leamor</h3>
                    <span>As</span>
                </div>

                <div class="col-md-6">
                    <a href="{{route('login', ['q'=>'teacher'])}}" class="btn-login">
                        <div class="card card-body bg-primary d-flex align-items-center justify-content-center">
                            <img src="{{asset('dist/img/teacher.png')}}" alt="err" width="150px" height="150px" />
                        </div>
                    </a>
                </div>
                
                <div class="col-md-6">
                    <a href="{{route('login', ['q'=>'student'])}}" class="btn-login">
                        <div class="card card-body bg-primary d-flex align-items-center justify-content-center">
                            <img src="{{asset('dist/img/student.png')}}" alt="err" width="150px" height="150px" />
                        </div>
                    </a>
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