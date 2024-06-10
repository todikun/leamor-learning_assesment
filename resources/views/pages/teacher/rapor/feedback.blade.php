
<form action="{{route('rapor.teacher.feedback_store', $data->id)}}" method="post">
    @csrf

    <input type="hidden" name="soal_detail_id" value="{{request('index')}}" />
    <h5 class="card-title mb-2">Feedback </h5>
    <textarea name="feedback" class="form-control summernote mb-2" cols="3" rows="3" required></textarea>

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

