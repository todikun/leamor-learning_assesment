
<form action="{{route('proyek.store')}}" method="post">
    @csrf

    <h5 class="card-title my-3">Nama Proyek <span class="text-danger">*</span></h5>
    <input type="text" name="nama" class="form-control mb-3" required />

    <h5 class="card-title my-3">Dapat berbagi <span class="text-danger">*</span></h5>
    <select name="is_share" class="form-control form-select mb-3" required>
        <option value="">PILIH</option>
        <option value="1">Ya</option>
        <option value="0">Tidak</option>
    </select>

    <button type="submit" class="form-control btn btn-primary">Simpan</button>
</form>

