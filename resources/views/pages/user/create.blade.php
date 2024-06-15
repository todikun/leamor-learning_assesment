
<form action="{{route('user.store')}}" method="post">
    @csrf

    <h5 class="card-title my-3">Nama  <span class="text-danger">*</span></h5>
    <input type="text" name="nama" class="form-control mb-3" required />


    <h5 class="card-title my-3">Username  <span class="text-danger">*</span></h5>
    <input type="text" name="username" class="form-control mb-3" required />


    <h5 class="card-title my-3">Password  <span class="text-danger">*</span></h5>
    <input type="password" name="password" class="form-control mb-3" required />

    <h5 class="card-title my-3">Konfirmasi Password  <span class="text-danger">*</span></h5>
    <input type="password" name="konfirmasi_password" class="form-control mb-3" required />

    <button type="submit" class="form-control btn btn-success">Simpan</button>
</form>

