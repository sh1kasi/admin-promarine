<form action="/kasbon/user/post" method="post">
    @csrf
    <div class="modal fade" id="inputKasbonModal" tabindex="-1" aria-labelledby="inputKasbonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="inputKasbonModalLabel">Input Kasbon</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group pb-1 input-daterange date">
                    <label for="exampleInputEmail1">Tanggal</label> <br>
                    <input style="width: 45%;" value="{{ $now->format('Y-m-d') }}" class="form-control @error('tanggal') is-invalid @enderror form-input mt-2 mb-2" id="tanggal" style="text-transform: uppercase;" aria-describedby="emailHelp" name="tanggal" />
                    @error('tanggal')    
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Kasbon</label>
                    <textarea class="form-control @error('desc') is-invalid @enderror" name="desc" id="exampleFormControlTextarea1" rows="3"></textarea>
                    @error('desc')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nominal_kasbon" class="form-label">Nominal</label>
                    <input type="text" class="form-control @error('nominal') is-invalid @enderror" name="nominal" id="nominal_kasbon" placeholder="50000">
                    @error('nominal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Buat Kasbon</button>
            </div>
          </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
    });

    $("#nominal_kasbon").keyup(function (e) { 
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