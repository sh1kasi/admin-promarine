@extends('layouts.admin')

@section('content')

@include('admin.modal.inputKasbon')

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Kasbon Anda</h5>
                        <div class="detail d-flex flex-column ms-2">
                            <div class="detail-success">
                                <p class="alert alert-success">- Jumlah kasbon yang telah dibayar: {{ $kasbon->where('status', 'success')->count() }}</p>
                            </div>
                            <div class="detail-pending">
                                <p class="alert alert-warning">
                                    - Jumlah nominal kasbon yang belum dibayar: 
                                    <b>
                                        @currency($total_pending) 
                                    </b>
                                </p> 
                            </div>
                            <div class="detail-rejected">
                                <p class="alert alert-danger">- Jumlah kasbon yang ditolak: {{ $kasbon->where('status', 'rejected')->count() }}</p><br>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="page-content mt-0">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h5 class="card-title">Kasbon</h5>
                        {{-- <button class="btn btn-primary mb-3" id="kasbonTable_wrapper" data-bs-toggle="modal" data-bs-target="#inputKasbonModal">Masukkan Kasbon</button> --}}
                        <a class="btn btn-primary mb-3" id="kasbonTable_wrapper" href="/kasbon/input">Tambah Kasbon</a>
                        <table id="kasbonTable" class="display table table-bordered table-lemburan" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>JOB</th>
                                    <th>Tanggal</th>
                                    <th>Nominal Kasbon</th>
                                    <th>Bukti Foto</th>
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pengki" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti Foto</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <img id="imageDetail" class="img-fluid" src="" alt="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

@if (Session::get('success'))
    <script>
        toastr.success("{!! session('success') !!}")
    </script>
@endif

<script>
    $(document).ready(function () {
        $("#kasbonTable").DataTable({
            processing: true,
            serverSide: true,
            filter: true,
            searching: true,
            ajax: {
                type: "GET",
                url: "/kasbon/user/json",
            },
            columns: [
                {data: 'DT_RowIndex', name: '#'},
                {data: 'job', name: 'job'},
                {data: 'date', name: 'date'},
                {data: 'nominal', name: 'nominal', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
                {data: 'foto', name: 'foto'},
                {data: 'status', name: 'status'},
                {data: 'description', name: 'description'},
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData.status === 'Selesai') {
                    $('td', nRow).css('color', '#155724');
                    $('td', nRow).css('background-color', '#d4edda');
                    $('td', nRow).css('border-color', '#c3e6cb');
                } else if (aData.status === 'Menunggu') {
                    $('td', nRow).css('background-color', '#fff3cd');
                    $('td', nRow).css('color', '#856404');
                    $('td', nRow).css('border-color', '#ffeeba');
                } else {
                    $('td', nRow).css('background-color', '#721c24');
                    $('td', nRow).css('background-color', '#f8d7da');
                    $('td', nRow).css('border-color', '#f5c6cb');
                }
            }
        });


    });

    function detailImage(photo) {
        $("#imageDetail").attr('src', photo);
        $("#pengki").modal('show');
    }

    function moreDetail(id) {
        window.open(`/kasbon/cetak?kasbon_id=${id}`);
    }

</script>
@endsection