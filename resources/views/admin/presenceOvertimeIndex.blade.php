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

                        @if (auth()->user()->role === 'admin')
                        <div class="d-flex justify-content-evenly input-daterange mb-4">
                            <div class="from_date d-flex">                              
                                <span style="font-size: 12px;">Dari tanggal: </span>
                                <input type="text" class="form-control mb-3" name="from" value="" id="from_date">
                            </div>
                            <div class="to_date d-flex ms-2">
                                <span style="font-size: 12px;">Hingga tanggal: </span>
                                <input type="text" class="form-control mb-3" name="to" value="" id="to_date">
                                <button class="btn btn-primary mb-3 ms-1" type="button" id="search_date"><i class="fa fa-search" aria-hidden="true"></i></i></button>
                                <button class="btn btn-warning mb-3 ms-1" type="button" id="refresh"><i class="fa fa-refresh" aria-hidden="true"></i></i></button>
                            </div>
                        </div>
                        @endif

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
@if (auth()->user()->role === 'user')
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
@endif

@if (auth()->user()->role === 'admin')
<script>
    $(document).ready(function () {

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        load_data();

        $("#search_date").click(function (e) { 
            e.preventDefault();
            // alert('a');
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            if (from_date != '' && to_date != '') {
                $("#employeeTableAdmin").DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                 toastr.error("Harap isi kedua tanggal tanggal tersebut!");
            }
        });

        $("#refresh").click(function (e) { 
            e.preventDefault();
            $("#from_date").val('');
            $("#to_date").val('');
            $("#employeeTableAdmin").DataTable().destroy();
            load_data();
        });

        function load_data(from_date = '', to_date = '',) {     
            // $.fn.dataTableExt.oStdClasses.sWrapper = "dataTables_wrapper mx-auto";
            $("#employeeTableAdmin").DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                searching: true,
                ajax: {
                    type: "GET",
                    url: "/lemburan/absen/admin/json",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', name: '#'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'action', name: 'action'},
                ]
            });
        }

    });
</script>

@endif

@if ($errors->any())
    <script>
        $(document).ready(function () {
            $('#inputPresence').modal('show');
        });
    </script>
@endif
    
@endsection