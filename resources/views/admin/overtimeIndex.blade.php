@extends('layouts.admin')

@section('content')

{{-- <style>
    #employeeTable_wrapper {
        margin-right: 15%;
        margin-left: 15%;
    }
</style> --}}

@include('admin.modal.inputOvertime')
@include('admin.modal.editOvertime')

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h5 class="card-title">Lemburan</h5>
                        <button class="btn btn-primary mb-3" id="employeeTable_wrapper" data-bs-toggle="modal" data-bs-target="#inputOvertime">Tambah</button>
                        <table id="employeeTable" class="display table table-bordered table-lemburan" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Lemburan</th>
                                    <th>Bayaran (per-jam)</th>
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

function deleteOvertime(id) {
    // alert('a');

        // var id = $(this).data('id');
            // console.log(id);
            var name = $(this).data('name');
            swal({
               title: "Kamu yakin?",
               text: "Lemburan ini akan terhapus!",
               icon: "warning",
               buttons: true,
               dangerMode: true,
               })
               .then((willDelete) => {
               if (willDelete) {
                   window.location = "/lemburan/delete/"+id+""
                   swal("Lemburan tersebut berhasil terhapus" , {
                   icon: "success",
                   buttons: false,
                   });
                   
               }
           });
    }

    $(document).ready(function () {
        $("#employeeTable").DataTable({
            processing: true,
            serverSide: true,
            filter: true,
            searching: true,
            ajax: {
                type: "GET",
                url: "/lemburan/json",
            },
            columns: [
                {data: 'DT_RowIndex', name: '#'},
                {data: 'name', name: 'name'},
                {data: 'per_hour', name: 'hour'},
                {data: 'action', name: 'action'},
            ]
        });
    });
</script>
    
@endsection