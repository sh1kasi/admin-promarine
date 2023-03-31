@extends('layouts.admin')

@section('content')

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="/kasbon/user/post" method="post" enctype="multipart/form-data">
                            @csrf
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
                                <input style="width: 45%" type="text" class="ms-4 mt-1 col-md-6 form-control @error('nominal') is-invalid @enderror" value="{{ @old('job_kasbon') }}" name="job_kasbon" id="job_kasbon" placeholder="Job Service">
                                @error('job_kasbon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="detail-kasbon table-responsive border-top border-bottom">
                                <table class="table table-bordered w-100" id="table">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th class="col-md-6">Item Barang</th>
                                        <th>Nominal</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <tr>
                                        <td class="w-15">
                                            <div class="input-daterange">
                                                <input type="text" name="input[0][date]" id="date" class="w-100 border rounded border-dark @error('input[0][date]') is-invalid @enderror">
                                                @error('input[0][date]')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="item-barang">
                                                <input type="text" name="input[0][item]" \ id="item" class="w-100 rounded border border-dark @error('input[0][item]') is-invalid @enderror">
                                                @error('input[0][item]')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="nominal">
                                                <div class="input">
                                                    <input type="text" name="input[0][nominal]" id="nominal_kasbon" class="border border-dark rounded w-100 @error('input[0][nominal]') @enderror">
                                                    @error('input[0][nominal]')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="clone-button mt-2 ms-3">
                                                <a type="button" class="text-primary clone"><i data-feather="plus-circle"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Deskripsi Kasbon</label>
                                <textarea class="form-control @error('desc') is-invalid @enderror" name="desc" id="exampleFormControlTextarea1" rows="3">{{ @old('desc') }}</textarea>
                                @error('desc')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <img class="img-preview img-fluid mb-3 mt-3" width="25%!important">
                                <label for="photo_kasbon" class="form-label">Foto Bukti Rekap Kasbon</label>
                                <input type="file" class="form-control  @error('photo') is-invalid @enderror" value="{{ @old('photo') }}" name="photo" id="photo_kasbon" placeholder="Kirim Bukti Rekap Foto">
                                @error('photo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-success w-100" type="submit">Buat Kasbon </button>
                            </div>
                        </form>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        var i = 0;

        $(".clone").click(function (e) { 
            e.preventDefault();

            ++i;
            
            $("#table").append(
                `<tr>
                <td>
                    <div class="input-daterange">
                        <input type="text" name="input[${i}][date]" id="date" class="form-control @error('input[${i}][date]') is-invalid @enderror">
                        @error('input[${i}][date]')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </td>
                <td>
                    <div class="item-barang">
                        <input type="text" name="input[${i}][item]" id="item" class="form-control @error('input[${i}][item]') is-invalid @enderror">
                        @error('input[${i}][item]')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </td>
                <td>
                    <div class="nominal">
                        <div class="input">
                            <input type="text" name="input[${i}][nominal]" id="nominal_kasbon" class="form-control @error('input[${i}][nominal]') is-invalid @enderror">
                            @error('input[${i}][nominal]')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </td>
                <td>
                    <div class="clone-button mt-2 ms-3">
                        <a type="button" class="text-danger delete-form"><i data-feather="trash-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></i></a>
                    </div>
                </td>
             </tr>`
        );

             
           
        
            $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true,
            });
        });

        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        $("#photo_kasbon").on('change', function () {
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


        $(document).on("click", '.delete-form', function () {
            $(this).parents('tr').remove();
        });

        $(document).on("keyup", '#nominal_kasbon', function () {
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
    });




</script>
    
@endsection