<form id="inputEmployeeForm" action="/pegawai/store" role="form" method="post">
@csrf
<div class="modal fade" id="inputEmployee" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        {{-- <span aria-hidden="true">&times;</span> --}}
                    </button>
            </div>
            <div class="modal-body">
                {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <ul>
                            <li>{{ $error }}</li>
                        </ul>
                    @endforeach
                </div>
                @endif --}}

                <div class="form-group">
                    <label for="user_id">Pilih akun Pegawai</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" aria-label="Default select example">
                        <option selected class="text-muted" value="">Pilih akun yang telah terdaftar</option>
                        @foreach ($user as $data)
                        <option value="{{ $data->id }}" {{ @old('user_id') == $data->id ? 'selected' : '' }} >{{ Str::ucfirst($data->name) }}</option>
                        @endforeach
                    </select>
                    @error('user_id')     
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="call_name">Nama pegawai</label>
                    <input type="text" id="call_name" name="call_name" value="{{ @old('call_name') }}" class="form-control @error('call_name') is-invalid @enderror w-75" placeholder="Masukkan Nama Pegawai"/>
                @error('call_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="role">Pilih Role Pegawai</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" aria-label="Default select example">
                        <option selected value="">Pilih role pegawai</option>
                        <option value="Permanent" {{ @old('role') === 'Permanent' ? 'selected' : '' }}>Permanent</option>
                        <option value="Helper" {{ @old('role') === 'Helper' ? 'selected' : '' }}>Helper</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mt-3">
                    <label for="role">Pilih metode gajian</label>
                    <select class="form-select @error('salary_method') is-invalid @enderror" id="salary_method" name="salary_method" aria-label="Default select example">
                        <option selected value="">Pilih metode gajian</option>
                        <option value="Harian" {{ @old('salary_method') === 'Harian' ? 'selected' : '' }}>Harian</option>
                        <option value="Bulanan" {{ @old('salary_method') === 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                    @error('salary_method')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label for="daily_salary">Nominal</label>
                    <input type="text" id="input_number" name="daily_salary" value="{{ @old('daily_salary') }}" class="form-control @error('daily_salary') is-invalid @enderror" placeholder="Masukkan nominal"/>
                @error('daily_salary')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
</form>

<script>
    $("#input_number").keyup(function (e) { 
        var angka = $(this).val();

        var hasilAngka = formatRibuan(angka);
        $(this).val(hasilAngka);
    });

    function formatRibuan(angka){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        angka_hasil     = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
 
 
 
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            angka_hasil += separator + ribuan.join('.');
        }
 
        angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil;
        return angka_hasil;
    }




</script>


