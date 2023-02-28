@extends('layouts.admin')

@section('content')
    
<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Gajian {{ Str::ucfirst($employee->users->name) }}</h5>
                        <button class="btn btn-primary mb-3" id="employeeTable_wrapper" data-bs-toggle="modal" data-bs-target="#inputEmployee">Tambah</button>
                        <div class="table-responsive">
                            <table id="employeeTable" class="display table table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Area</th>
                                        <th>Lemburan</th>
                                        <th>Total Bayaran Perhari</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="id" value="{{ $id }}" id="id">

<script>
    var id = $("#id").val();
    $(document).ready(function () {
      var employeeTable =  $("#employeeTable").DataTable({
            processing: true,
            serverSide: false,  
            filter: true,
            // responsive: true,
            searching: true,
            // scrollX: true,
            scrollCollapse: true,
            data: {
                id: id,
            },
            ajax: {
                type: "GET",
                url: "/pegawai/detail/json/"+id+"",
            },
            columns: [
                {data: 'DT_RowIndex', name: '#'},
                {data: 'date', name: 'date'},
                {data: 'area', name: 'area'},
                {data: 'overtime', name: 'overtime'},
                {data: 'total_salary', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
            ]
        });

        new $.fn.dataTable.FixedHeader(employeeTable);

    });
</script>

@endsection