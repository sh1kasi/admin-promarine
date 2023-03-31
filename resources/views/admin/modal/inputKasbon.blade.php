<form action="/kasbon/user/post" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="inputKasbonModal" tabindex="-1" aria-labelledby="inputKasbonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="inputKasbonModalLabel">Input Kasbon</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group pb-1 input-daterange date row">
                    <label for="exampleInputEmail1" class="mt-3 col-md-6">Tanggal Kasbon</label> <br>
                    <input style="width: 45%;" value="{{ $now->format('Y-m-d') }}" class="ms-4 mt-1 col-md-6 form-control @error('tanggal') is-invalid @enderror form-input mt-2 mb-2" id="tanggal" style="text-transform: uppercase;" aria-describedby="emailHelp" name="tanggal" />
                    @error('tanggal')    
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="nominal_kasbon" class="form-label mt-3 col-md-6">Jumlah</label>
                    <input style="width: 45%" type="text" class="ms-4 mt-1 col-md-6 form-control @error('nominal') is-invalid @enderror" value="{{ @old('nominal') }}" name="nominal" id="nominal_kasbon" placeholder="50000">
                    @error('nominal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="job_kasbon" class="form-label mt-3 col-md-6">Job</label>
                    <input style="width: 45%" type="text" class="ms-4 mt-1 col-md-6 form-control @error('nominal') is-invalid @enderror" value="{{ @old('job') }}" name="job_kasbon" id="job_kasbon" placeholder="Job Service">
                    @error('job_kasbon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="detail-kasbon table-responsive border-top border-bottom">
                    <div class="container mt-3 mb-3">
                        <div class="row form-rekap">
                            <div class="col-sm-4">
                                <label for="date">Tanggal</label>
                                <input type="text" name="date" id="date" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label for="item_barang">Item Barang</label>
                                <input type="text" name="item_barang" id="item_barang" class="form-control">
                            </div>
                            <div class="col-sm-4 d-flex">
                                <div class="input">
                                    <label for="nominal">Nominal</label>
                                    <input type="text" name="nominal" id="nominal" class="form-control">
                                </div>
                                <div class="delete mt-4 ms-3">
                                    <button class="btn btn-danger btn-sm rounded">X</button>
                                </div>
                            </div>
                        </div>
                            <div class="clone-button mt-3">
                                <button class="btn btn-primary rounded clone w-100">Tambah</button>
                            </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Kasbon</label>
                    <textarea class="form-control @error('desc') is-invalid @enderror" name="desc" id="exampleFormControlTextarea1" rows="3">{{ @old('desc') }}</textarea>
                    @error('desc')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <img class="img-preview img-fluid mb-3">
                    <label for="nominal_kasbon" class="form-label">Foto Bukti Rekap Kasbon</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" value="{{ @old('photo') }}" name="photo" id="photo_kasbon" placeholder="Kirim Bukti Rekap Foto">
                    @error('photo')
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

    $(".clone").click(function (e) { 
        e.preventDefault();
        $(".detail-kasbon .container .form-rekap:last-child").clone().appendTo('.container');
    });

    $("#photo_kasbon").on('change', function () {
        console.log('sdfdsfs');
        const image = document.querySelector("#photo_kasbon");
        const img_preview = document.querySelector(".img-preview");
        
        img_preview.style.display = "block";

        const oFReader = new FileReader();
        console.log(oFReader);
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function (OFREvent) {
            img_preview.src = OFREvent.target.result;
        }
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