@extends('layouts.app')

@section('title', 'Soal')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center my-2">{{$soal->Proyek->nama}}</h2>
                <h5 class="text-center mt-2 my-5">{{$soal->nama}}</h5>
                
                <form action="{{route('soal.open-akses.store')}}" method="post">
                    @csrf
                    <input type="hidden" value="{{$soal->id}}" name="soal_id" />

                    <div class="col-md-3 mx-auto">
                        <h5 class="card-title my-3">Dapat diakses mandiri <span class="text-danger">*</span></h5>
                        <div class="input-group mb-3">
                            <select class="form-control form-select mb-3 is-mandiri" name="is_mandiri" required>
                                <option value="">-- PILIH --</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>

                        <div id="tokenDiv" class="token-div d-none">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control time-picker" readonly name="jam_ujian" placeholder="HH:MM" required />
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control date-picker" readonly name="tanggal_ujian" placeholder="yyyy-mm-dd" required />
                            </div>

                            <h5 class="card-title my-3">Kode <span class="text-danger">*</span></h5>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control token-value" readonly name="token" required />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success position-fixed my-5 mx-5" style="bottom: 0; right: 0;">
                        SAVE
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>

        $('.is-mandiri').on('change', function(e){
            var isMandiri = e.currentTarget.value;
            var timePicker = $('.time-picker');
            var datePicker = $('.date-picker');
            var tokenValue = $('.token-value');
            var tokenDiv = $('.token-div');

            if (isMandiri === '0') {
                tokenValue.val(generateRandomString());
                tokenDiv.hasClass('d-none') ? tokenDiv.removeClass('d-none') : '';
                return;
            }
            timePicker.val('');
            datePicker.val('');
            tokenValue.val('');
            !tokenDiv.hasClass('d-none') ? tokenDiv.addClass('d-none') : '';

        });

        function generateRandomString() {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            for (let i = 0; i < 30; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
        
        $('.time-picker').timepicker({
            uiLibrary: 'bootstrap5',
            mode: '24hr',
        });

        $('.date-picker').datepicker({
            uiLibrary: 'bootstrap5',
            iconsLibrary: 'fontawesome',
            format: 'yyyy-mm-dd'
        });
    </script>
@endpush