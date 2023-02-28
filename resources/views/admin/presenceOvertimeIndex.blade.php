@extends('layouts.admin')

@section('content')

{{-- @dd(strtotime($currentDate)); --}}


@include('admin.modal.inputOvertime')
@include('admin.modal.inputPresenceOvertime')
@include('admin.modal.overtimeDetail')

@if ($errors->any())
    <script>
        $(document).ready(function () {
            $('#inputPresenceOvertime').modal('show');
        });
    </script>
@endif
<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h5 class="card-title">Absen Lemburan</h5>
                        <button class="btn btn-primary mb-3 {{ auth()->user()->role === 'admin' ? 'd-none' : '' }}"
                            {{-- @if ($now->format('D') === 'Sat')
                                @if (strtotime($currentTime) < '12:00')
                                    disabled
                                @endif
                            @endif --}}
                            id="employeeTable_wrapper" data-bs-toggle="modal" data-bs-target="#inputPresenceOvertime">Absen Lembur</button>
                        @if (auth()->user()->role === 'user')    
                            <table id="employeeTableUser" class="display table table-responsive text-center table-bordered" style="width:100%; margin-top: 40px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Nama Lemburan</th>
                                        <th>Jam lembur</th>
                                        <th>Bayaran</th>
                                    </tr>
                                </thead>
                            </table>
                        @else
                            <table id="employeeTableAdmin" class="display table table-responsive text-center table-bordered" style="width:100%; margin-top: 40px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                            </table>
                        @endif
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
@elseif (Session::get('failed'))
    <script>
        toastr.error("{!! session('failed') !!}")
    </script>
@endif

@if ($employee == null)
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
@else
@if (auth()->user()->role === 'user')
    <script>
        $(document).ready(function () {

            // $(".dataTables_wrapper").addClass("mx-auto");

            $.fn.dataTableExt.oStdClasses.sWrapper = "dataTables_wrapper mx-auto";
            $("#employeeTableUser").DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                searching: true,
                ajax: {
                    type: "GET",
                    url: "/lemburan/absen/json",
                },
                columns: [
                    {data: 'DT_RowIndex', name: '#'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'overtime_name', name: 'overtime_name'},
                    {data: 'overtime_hour', name: 'overtime_hour'},
                    {data: 'salary', name: 'salary'},
                ]
            });
        });
    </script>
@endif

@if (auth()->user()->role === 'admin')
<script>
    $(document).ready(function () {
        $.fn.dataTableExt.oStdClasses.sWrapper = "dataTables_wrapper mx-auto";
        $("#employeeTableAdmin").DataTable({
            processing: true,
            serverSide: true,
            filter: true,
            searching: true,
            ajax: {
                type: "GET",
                url: "/lemburan/absen/admin/json",
            },
            columns: [
                {data: 'DT_RowIndex', name: '#'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'action', name: 'action'},
            ]
        });
    });
</script>
@endif

@endif

@if ($errors->any())
    <script>
        $(document).ready(function () {
            $('#inputPresence').modal('show');
        });
    </script>
@endif
    
@endsection