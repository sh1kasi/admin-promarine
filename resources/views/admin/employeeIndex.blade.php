@extends('layouts.admin')

@section('content')

@include('admin.modal.inputEmployee')
@include('admin.modal.editEmployee')

{{-- @dd($message); --}}

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pegawai</h5>
                        <button class="btn btn-primary mb-3" id="employeeTable_wrapper" data-bs-toggle="modal" data-bs-target="#inputEmployee">Tambah</button>
                        <div class="table-responsive">
                            <table id="employeeTable" class="display table table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jabatan</th>
                                        <th>Metode Gajian</th>
                                        <th>Nominal Gajian</th>
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
</div>

@if (Session::get('success'))
    <script>
        toastr.success("{!! session('success') !!}")
    </script>
@endif


<script>

    function deleteEmployee(id) {
    // alert('a');

        // var id = $(this).data('id');
            // console.log(id);
            var name = $(this).data('name');
            swal({
               title: "Kamu yakin?",
               text: "Pegawai ini akan terhapus!",
               icon: "warning",
               buttons: true,
               dangerMode: true,
               })
               .then((willDelete) => {
               if (willDelete) {
                   window.location = "/pegawai/delete/"+id+""
                   swal("Pegawai tersebut berhasil terhapus" , {
                   icon: "success",
                   buttons: false,
                   });
                   
               }
           });
    }

    // $(document).ready(function () {
        
        
    //     $(".delete_employee").click(function (e) { 
    //         e.preventDefault();

    //         alert('a');
            
    //         var id = $(this).data('id');
    //         // console.log(id);
    //         var name = $(this).data('name');
    //         swal({
    //            title: "Kamu yakin?",
    //            text: "Pegawai yang bernama " +name+" akan terhapus!",
    //            icon: "warning",
    //            buttons: true,
    //            dangerMode: true,
    //            })
    //            .then((willDelete) => {
    //            if (willDelete) {
    //                window.location = "/pegawai/delete/"+id+""
    //                swal("Pegawai bernama "+name+" berhasil terhapus" , {
    //                icon: "success",
    //                buttons: false,
    //                });
                   
    //            }
    //        });

    //     });

    // });

</script>

<script>
    $(document).ready(function () {
      var employeeTable =  $("#employeeTable").DataTable({
            processing: true,
            serverSide: false,
            filter: true,
            // responsive: true,
            searching: true,
            // scrollX: true,
            scrollCollapse: true,
            ajax: {
                type: "GET",
                url: "/pegawai/json",
            },
            columns: [
                {data: 'DT_RowIndex', name: '#'},
                {data: 'name', name: 'name'},
                {data: 'role', name: 'role'},
                {data: 'salary_method', name: 'salary_method'},
                {data: 'daily_salary', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
                {data: 'action', name: 'action'},
            ]
        });

        new $.fn.dataTable.FixedHeader(employeeTable);

    });
</script>
    
@endsection