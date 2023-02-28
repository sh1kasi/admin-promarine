@if (auth()->user()->role != 'admin')
    
@if ($employee == !null)
<form action="/kehadiran/store" method="POST">
    @csrf
    <div class="modal fade" id="inputPresence" tabindex="-1" role="dialog" aria-labelledby="inputPresenceLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputPresenceLabel">Input Absen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
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
                    <div class="row pt-1 pb-3" style="border-bottom: 1px solid #c5bebefa;">
                        <div class="form-group mt-3 col-md-6">
                            <label class="form-check-label" style="font-size: 15px" for="area">Pilih Area Kerja Hari ini</label>
                            <select class="form-select @error('area') is-invalid @enderror" id="area"
                            name="area" aria-label="Default select example">
                                <option selected value="">Pilih Area Kerja</option>
                                <option value="1" {{ @old('area') == 1 ? 'selected' : '' }}>Area Gerbang Kertasusila</option>
                                <option value="2" {{ @old('area') == 2 ? 'selected' : '' }}>Area Pulau Jawa selain Gerbang Kertasusila</option>
                                <option value="3" {{ @old('area') == 3 ? 'selected' : '' }}>Area Luar Pulau Jawa selain Bangkalan</option>
                                <option value="4" {{ @old('area') == 4 ? 'selected' : '' }}>Area Offshore / Anchorage</option>
                            </select>
                            @error('area')    
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                                @enderror
                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Hadir</button>
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> --}}
                    {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
                </div>
            </div>
        </div>
    </div>
</form>
@else
    <script>
        $(document).ready(function () {
            swal({
                title: "Kesalahan!",
                icon: "error",
                text: "Akun anda belum terdaftar sebagai pegawai, mohon hubungi admin",
                showConfirmButton: false,
            }).then(function () {
                window.location = "/home";
            });
        });
        
    </script>
@endif
@endif




<script>
    $(document).ready(function () {
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

    });

</script>
