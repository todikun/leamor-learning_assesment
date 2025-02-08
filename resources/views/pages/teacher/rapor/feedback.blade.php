
<form action="{{route('rapor.teacher.feedback_store', $data->id)}}" method="post">
    @csrf

    <input type="hidden" name="no_soal" value="{{$index}}" />
    <h5 class="card-title mb-2">Feedback </h5>
    <textarea name="feedback" class="form-control summernote mb-2" cols="3" rows="3" required>{{$data->feedback[$index]}}</textarea>

    @if (auth()->user()->role == 'teacher')
        <button type="submit" class="form-control btn btn-success mt-2">Update</button>
    @endif
</form>

<script>
    $('.summernote').summernote({
        tabsize: 2,
        minHeight: 220,
        maxHeight: null,
        toolbar: [
            ['insert', ['picture']],
        ]
    });
</script>

