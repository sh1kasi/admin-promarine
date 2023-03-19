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
                                        @php
                                            $total_pending = 0;
                                        @endphp
                                        @foreach ($kasbon->where('status', 'pending') as $data)
                                            @currency($total_pending += $data->nominal)
                                        @endforeach 
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
                        <button class="btn btn-primary mb-3" id="kasbonTable_wrapper" data-bs-toggle="modal" data-bs-target="#inputKasbonModal">Masukkan Kasbon</button>
                        <table id="kasbonTable" class="display table table-bordered table-lemburan" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Nominal Kasbon</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>      
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
                {data: 'date', name: 'date'},
                {data: 'nominal', name: 'nominal', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
                {data: 'description', name: 'description'},
                {data: 'status', name: 'status'},
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
</script>
@endsection