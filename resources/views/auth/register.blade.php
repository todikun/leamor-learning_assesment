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
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('dist/landing/assets/img/icons/logo-padang.png') }}">

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

    <title>Register | Leamor</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="{{ asset('dist/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        @php
                            $param = request('q');
                        @endphp
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title my-2">
                                    <h3 class="text-center">Leamor</h3>
                                    <h5 class="text-center">Register</span>
                                </div>
                                @include('components.alert')

                                <div class="m-sm-4">
                                    
                                    <form action="{{route('register.store')}}" method="post">
                                        @csrf

                                        <input type="hidden" name="role" value="{{request('q')}}">
                                        <h5 class="card-title my-3">Nama  <span class="text-danger">*</span></h5>
                                        <input type="text" name="nama" class="form-control mb-3" required />


                                        <h5 class="card-title my-3">Username  <span class="text-danger">*</span></h5>
                                        <input type="text" name="username" class="form-control mb-3" required />
                                        
                                        @if (request('q') == 'teacher')
                                            <h5 class="card-title my-3">Email  <span class="text-danger">*</span></h5>
                                            <input type="email" name="email" class="form-control mb-3" required />

                                            <h5 class="card-title my-3">Sekolah  <span class="text-danger">*</span></h5>
                                            <input type="text" name="sekolah" class="form-control mb-3" required/>
                                        @endif
                                        

                                        <h5 class="card-title my-3">Password  <span class="text-danger">*</span></h5>
                                        <input type="password" name="password" class="form-control mb-3" required />

                                        <h5 class="card-title my-3">Konfirmasi Password  <span class="text-danger">*</span></h5>
                                        <input type="password" name="konfirmasi_password" class="form-control mb-3" required />

                                        <button type="submit" class="form-control btn btn-success">Simpan</button>
                                    </form>

                                </div>
                            </div>
                            <p class="text-center text-muted">
                                &copy; 2024 <strong>Olyivia Retdwina Rusma</strong>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('dist/js/app.js') }}"></script>

</body>

</html>
