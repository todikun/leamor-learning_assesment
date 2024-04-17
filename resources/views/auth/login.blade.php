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

    <title>Log In | Leamor</title>

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
                                    <h5 class="text-center">Login As <b>{{$param}}</b></span>
                                </div>
                                @include('components.alert')

                                <div class="m-sm-4">

                                    <div class="text-center">
                                        <a href="{{ url('/') }}">
                                            <img src="{{ asset('dist/img/'.$param.'.png') }}" alt="img"
                                                class="img-fluid rounded bg-primary" width="132" height="132" />
                                        </a>
                                    </div>

                                    <form action="{{ route('login.action') }}" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input class="form-control form-control-lg" type="text" name="username"
                                                placeholder="Masukkan Username" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Masukkan password" required />
                                        </div>

                                        <input type="submit" value="Login"
                                            class="form-control btn btn-lg btn-primary">
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
