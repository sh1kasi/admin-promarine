<form action="/lemburan/presence/store" method="post">
    @csrf
    <div class="modal fade" id="inputPresenceOvertime" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Absen Lemburan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        {{-- <span aria-hidden="true">&times;</span> --}}
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group pb-1 input-daterange date">
                        <label for="exampleInputEmail1">Tanggal</label> <br>
                        <input style="width: 45%;" value="{{ $currentDate }}" class="form-control @error('tanggal') is-invalid @enderror form-input mt-2 mb-2" id="tanggal" style="text-transform: uppercase;" aria-describedby="emailHelp" name="tanggal" />
                        @error('tanggal')    
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lemburan">Pilih Lemburan</label>
                        <select class="form-select @error('lemburan') is-invalid @enderror" aria-label="Default select example" name="lemburan">
                            <option selected value="">Pilih Lemburan yang Tersedia</option>
                            @foreach ($overtime as $lembur)
                            <option {{ @old('lemburan') == $lembur->id ? 'selected' : '' }} value="{{ $lembur->id }}">{{ $lembur->name }} - (@currency($lembur->per_hour)/jam)
                            </option>
                            @endforeach
                        </select>
                        @error('lemburan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-6">
                            <p style="width: 155px; font-size: 12px">Jam Lembur</p>
                            <input type="number" name="from_time" value="{{ @old('from_time') }}" class="form-control @error('from_time') is-invalid @enderror" placeholder="Masukkan Angka" id="datetimepicker1"/>
                            @error('from_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <p style="width: 155px; font-size: 12px">Hingga Jam: </p>
                            <input type="text" name="to_time" value="{{ @old('to_time') }}" class="form-control datetimepicker-input @error('to_time') is-invalid @enderror" id="datetimepicker2" data-toggle="datetimepicker" data-target="#datetimepicker2"/>
                            @error('to_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Absen</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>

    $(document).ready(function () {
    //     $("#datetimepicker1, #datetimepicker2").datetimepicker({
    //         format: 'HH:mm',
    //         pickDate: false,
    //         pickSeconds: false,
    //         pick12HourFormat: false,
    //     });
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    });

</script>
