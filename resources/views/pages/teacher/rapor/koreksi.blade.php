
<form action="{{route('rapor.teacher.koreksi_store', $data->id)}}" method="post">
    @csrf

    <input type="hidden" name="no_soal" value="{{request('index')}}" />
    <h5 class="card-title mb-2">Nilai </h5>
    <input type="number" name="nilai" class="form-control mb-2" required />

    <button type="submit" class="form-control btn btn-primary mt-2">Simpan</button>
</form>

<script>
    $('.summernote').summernote({
        tabsize: 2,
        height: 120,
        toolbar: [
            ['insert', ['picture']],
        ]
    });
</script>

