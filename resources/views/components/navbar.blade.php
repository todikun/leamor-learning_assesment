<div class="navbar-collapse collapse">
	
	@if (isset($ujian))
	<div class="d-flex justify-content-center w-100 mt-1">
		<div class="text-center">
			<h4 class="text-center mb-1 fw-bold" id="waktuMundur">{{$soal->waktu_ujian}} menit 0 detik</h3>
			<p class="text-center">Topik <strong>{{$soal->nama}}</strong></p>
		</div>
	</div>
	@endif

	<ul class="navbar-nav navbar-align">
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" title="{{strtoupper(auth()->user()->nama)}}" data-bs-toggle="dropdown">
				<i class="align-middle me-1" data-feather="user"></i>{{auth()->user()->nama}}</a>
			<div class="dropdown-menu dropdown-menu-end">
				@if (in_array(auth()->user()->role, ['admin']))
					<a class="dropdown-item {{Route::is('user.index') ? 'active' : ''}}" href="{{route('user.index')}}" >Manajemen Akun</a>
				@endif
				<a class="dropdown-item btn-edit" href="{{route('user.edit', auth()->user()->id)}}" >Profile</a>

				<a class="dropdown-item" href="#" onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">Logout
					<form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
						@csrf
					</form>
				</a>
			</div>
		</li>
	</ul>
</div>

{{-- <script>
	$('.btn-edit').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');

        $.ajax({
            url: url,
            dataType: 'HTML',
            method: 'GET',
            success: function (result) {
                $('#modal-form').find('#modal-label').html('Edit');
                $('#modal-form').find('.modal-body').html(result);
                $('#modal-form').modal('show');
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
</script> --}}