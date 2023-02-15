@extends('layouts.admin')

@section('content')

<style>
    #employeeTable_length {
        margin-left: 191px;
    }
    #employeeTable_info {
        margin-left: 191px;
    }
    #employeeTable_paginate {
        margin-right: 178px;
    }
    .dataTables_filter {
        margin-right: 191px;
    }
</style>

@include('admin.modal.presenceInput')
@include('admin.modal.presenceDetail')

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kehadiran</h5>
                        <button class="text-primary btn-primary btn {{ auth()->user()->role === "admin" ? 'd-none' : '' }}" type="button" id="inputPresence" data-bs-toggle="modal" data-bs-target="#inputPresence">Absen</button>
                        <table id="employeeTable" class="display table table-bordered pt-3" style="width:75%; margin-top: 40px; text-align: center;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Cek Kehadiran</th>
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
@elseif (Session::get('failed'))
    <script>
        toastr.error("{!! session('failed') !!}")
    </script>
@endif

@if ($errors->any())
    <script>
        $(document).ready(function () {
            $('#inputPresence').modal('show');
        });
    </script>
@endif


<script>
    $(document).ready(function () {
        $("#employeeTable").DataTable({
            processing: true,
            serverSide: true,
            filter: true,
            responsive: true,
            searching: true,
            ajax: {
                type: "GET",
                url: "/kehadiran/json",
            },
            columns: [
                {data: 'DT_RowIndex', name: '#'},
                {data: 'date', name: 'date'},
                {data: 'action', name: 'action'},
            ]
        });
    });

</script>

@endsection