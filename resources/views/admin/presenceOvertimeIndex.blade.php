@extends('layouts.admin')

@section('content')


@include('admin.modal.inputOvertime')
@include('admin.modal.inputPresenceOvertime')

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Absen Lemburan</h5>
                        <button class="btn btn-primary mb-3" id="employeeTable_wrapper" data-bs-toggle="modal" data-bs-target="#inputPresenceOvertime">Absen Lembur</button>
                        <table id="employeeTable" class="display table table-responsive text-center table-bordered" style="width:100%; margin-top: 40px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pegawai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // $(".dataTables_wrapper").addClass("mx-auto");

        $.fn.dataTableExt.oStdClasses.sWrapper = "dataTables_wrapper mx-auto";
        $("#employeeTable").DataTable({
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
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action'},
            ]
        });
    });
</script>
    
@endsection