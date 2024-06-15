
<form action="{{route('user.update', $data->id)}}" method="post">
    @csrf
    @method('put')

    <h5 class="card-title my-3">Nama <span class="text-danger">*</span></h5>
    <input type="text" value="{{$data->nama}}" name="nama" class="form-control mb-3" required />


    <h5 class="card-title my-3">Username  <span class="text-danger">*</span></h5>
    <input type="text" value="{{$data->username}}" name="username" class="form-control mb-3" required />


    <h5 class="card-title my-3">Password</h5>
    <input type="password" name="password" class="form-control mb-3"  />

    <h5 class="card-title my-3">Konfirmasi Password</h5>
    <input type="password" name="konfirmasi_password" class="form-control mb-3"  />

    <button type="submit" class="form-control btn btn-success">Simpan</button>
</form>

