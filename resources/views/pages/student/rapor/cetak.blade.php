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

    <title>Rapor | {{env('APP_NAME')}}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link href="{{ asset('dist/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .table-spacing th {
            padding-right: 10px; /* Add space to the right */
        }

        .table-spacing th:not(:last-child) {
            border-right: 10px solid transparent; /* Add space between th elements */
        }

        .connected-hr {
            padding-left: 0;
            padding-right: 0;
        }

        .connected-hr hr {
            margin-top: 8px;
            margin-bottom: 8px;
            border-top: 2px solid #28a745; /* Same color as text-success */
        }

        .connected-hr p {
            margin-bottom: 0;
        }

        /* Ensure columns are close to each other */
        .row > [class*='col-'] {
            padding-left: 0;
            padding-right: 0;
        }

    </style>
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-md-12 mx-auto d-table h-100">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p style="font-size: 40px; letter-spacing: 6px;" class="fw-bold text-success">REPORT CARD</p>
                                <p style="font-size: 30px; color: black; letter-spacing: 6px;">{{env('APP_NAME')}}</p>
                            </div>

                            <div class="row justify-content-between px-5">
                                <div class="mt-5 fw-bold col" style="font-size: 14px;">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <p>Tanggal</p>
                                            <p>Jam</p>
                                        </div>
                                        <div class="col-md">
                                            <p>: {{$data->tanggal_format}}</p>
                                            <p>: {{$data->jam_format}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 fw-bold col" style="font-size: 14px;">
                                    <div class="row" style="float: right;">
                                        <div style="font-size: 42px;" class="fw-bold">{{$data->total_nilai}}</div>
                                    </div>
                                </div>

                                <hr class="text-success py-1" >
                            </div>

                            <div class="row justify-content-center d-flex">
                                <div class="col-md-4 connected-hr">
                                    @foreach ($data->Soal->pernyataan as $item)
                                        <p>{{$item}}</p>
                                        <hr class="text-success pt-1">
                                    @endforeach
                                    <p>Materi</p>
                                    <hr class="text-success pt-1">
                                    <p>Nilai</p>
                                    <hr class="text-success pt-1">
                                    <p>Peringkat</p>
                                    <hr class="text-success pt-1">
                                </div>
                                <div class="col-md-6 connected-hr fw-bold">
                                    @foreach ($data->pernyataan as $item)
                                        <p>: {{$item}}</p>
                                        <hr class="text-success pt-1">
                                    @endforeach
                                    <p>: {{$data->Soal->nama}}</p>
                                    <hr class="text-success pt-1">
                                    <p>: {{$data->total_nilai}}</p>
                                    <hr class="text-success pt-1">
                                    <p>: {{$rank}}</p>
                                    <hr class="text-success pt-1">
                                </div>
                            </div>

                            <div class="row justify-content-center px-5 mx-5 text-center mt-3">
                                <table class="table table-spacing">
                                    <thead>
                                        <tr>
                                            <th class="bg-success text-white p-3 border-right">Soal</th>
                                            <th class="bg-success text-white p-3 border-right">Jawaban</th>
                                            <th class="bg-success text-white p-3">Feedback</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->Soal->SoalDetail as $key => $item)
                                            <tr>
                                                <td>{!!$item->pertanyaan!!}</td>
                                                <td>
                                                @if (is_array($data->jawaban[$key]))
                                                    @foreach ($data->jawaban[$key] as $j)
                                                        {!!$j!!}, 
                                                    @endforeach
                                                @else
                                                    {!!$data->jawaban[$key]!!}
                                                @endif</td>
                                                <td>{!!$data->feedback[$key] ?? '-'!!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script>
        window.print();
    </script>

</body>

</html>
