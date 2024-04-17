<nav id="sidebar" class="sidebar js-sidebar collapsed">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="{{ url('dashboard') }}">
			<span class="align-middle">Leamor</span>
		</a>

		<ul class="sidebar-nav">

			<li class="sidebar-item {{Route::is('proyek.index') ? 'active' : ''}}">
				<a class="sidebar-link" href="{{route('proyek.index')}}">
					<i class="align-middle " data-feather="folder"></i> <span class="align-middle">Semua Proyek</span>
				</a>
			</li>

			<li class="sidebar-item {{Route::is(['proyek.my', 'soal.*']) ? 'active' : ''}}">
				<a class="sidebar-link" href="{{route('proyek.my')}}">
					<i class="align-middle " data-feather="file-text"></i> <span class="align-middle">Proyek Anda</span>
				</a>
			</li>

			<li class="sidebar-item {{Route::is('/') ? 'active' : ''}}">
				<a class="sidebar-link" href="{{url('/')}}">
					<i class="align-middle " data-feather="layers"></i> <span class="align-middle">Rapor</span>
				</a>
			</li>

			<li class="sidebar-item {{Route::is('proyek.deleted') ? 'active' : ''}}">
				<a class="sidebar-link" href="{{route('proyek.deleted')}}">
					<i class="align-middle " data-feather="trash"></i> <span class="align-middle">Sampah</span>
				</a>
			</li>
		</ul>
	</div>
</nav>