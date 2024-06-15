
<form action="{{route('proyek.update', $data->id)}}" method="post">
    @csrf
    @method('put')

    <h5 class="card-title my-3">Nama Proyek <span class="text-danger">*</span></h5>
    <input type="text" name="nama" value="{{$data->nama}}" class="form-control mb-3" required />

    <h5 class="card-title my-3">Dapat berbagi <span class="text-danger">*</span></h5>
    <select name="is_share" class="form-control form-select mb-3" required>
        <option value="">PILIH</option>
        <option {{$data->is_share == 1 ? 'selected':''}} value="1">Ya</option>
        <option {{$data->is_share == 0 ? 'selected':''}} value="0">Tidak</option>
    </select>

    <button type="submit" class="btn btn-success">Simpan</button>

    <a href="{{route('proyek.undo', $data->id)}}" onclick="return confirm('Apa anda yakin menghapus proyek ini?')" class="btn btn-danger">Hapus</a>
</form>

