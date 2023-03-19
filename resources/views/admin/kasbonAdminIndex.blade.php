@extends('layouts.admin')

@section('content')
<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Filter Kasbon Pegawai</h5>
                        <div class="filter row col-md">
                            <div class="d-flex justify-content-between input-daterange mb-4">
                                <div class="from_date d-flex w-50">                              
                                    <span style="font-size: 12px;">Dari tanggal: </span>
                                    <input type="text" class="form-control mb-3" name="from" value="" id="from_date">
                                </div>
                                <div class="to_date d-flex ms-2 w-50">
                                    <span style="font-size: 12px;" class="ms-4">Hingga tanggal: </span>
                                    <input type="text" class="form-control mb-3" name="to" value="" id="to_date">
                                </div>
                            </div>
                            <div class="specific-filter row d-flex justify-content-between">
                                <div class="name-filter w-50">
                                    <span style="font-size: 12px;">Pilih Nama Pegawai</span>
                                    <select class="form-control" id="select_employee">
                                        @foreach ($kasbon as $data)
                                            <option value="{{ $data->employee_id }}">{{ Str::ucfirst($data->employees->users->name) }}</option>
                                        @endforeach    
                                    </select>
                                </div>
                                <div class="status-filter w-50">
                                    <span style="font-size: 12px;">Pilih Status Kasbon</span>
                                    <select class="form-control" id="select_status">
                                            <option value="success">Selesai</option>
                                            <option value="pending">Menunggu</option>
                                            <option value="rejected">Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="button d-flex justify-content-center">
                            <button class="btn btn-primary mt-4 ms-2" type="button" id="search_date"><i class="fa fa-search" aria-hidden="true"></i></i></button>
                            <button class="btn btn-warning mt-4 ms-2" type="button" id="refresh"><i class="fa fa-refresh" aria-hidden="true"></i></i></button>
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
                        <h5 class="card-title">Kasbon Pegawai</h5>
                        {{-- <button class="btn btn-primary mb-3" id="employeeTable_wrapper" data-bs-toggle="modal" data-bs-target="#inputOvertime">Tambah</button> --}}
                        <table id="kasbonTable" class="display table table-bordered table-lemburan" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pegawai</th>
                                    <th>Tanggal</th>
                                    <th>Nominal Kasbon</th>
                                    <th>Status</th>
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

        $('.input-daterange').datepicker({
            todayBtn: 'linked',
            format: 'yyyy-mm-dd',
            autoclose: true,
        });

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        load_data();

        $("#search_date").click(function (e) { 
            e.preventDefault();
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var employee_id = $("#select_employee").val();
            var status = $("#status").val();
            if (from_date != '' && to_date != '') {
                $("#employeeTable").DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                 toastr.error("Harap isi minimal 1 filter!");
            }
            if (employee_id != '') {
                $("#employeeTable").DataTable().destroy();
                load_data(employee_id)
            } else {
                toastr.error("Harap isi minimal 1 filter!")
            }
            if (status != '') {
                $("#employeeTable").DataTable().destroy();
                load_data(status)
            } else {
                toastr.error("Harap isi minimal 1 filter!")
            }
        });

        $("#refresh").click(function (e) { 
            e.preventDefault();
            $("#from_date").val('');
            $("#to_date").val('');
            $("#select_employee").val('');
            $("#status").val('');
            $("#employeeTable").DataTable().destroy();
            load_data();
        });

        function load_data(from_date = '', to_date = '', employee_id = '', status = '') {
            $("#kasbonTable").DataTable({
                    processing: true,
                    serverSide: true,
                    filter: true,
                    searching: true,
                    ajax: {
                        type: "GET",
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            employee_id: employee_id,
                            status: status,
                        },
                        url: "/kasbon/admin/json",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: '#'},
                        {data: 'name', name: 'name'},
                        {data: 'date', name: 'date'},
                        {data: 'nominal', name: 'nominal', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
                        {data: 'status', name: 'status'},
                        {data: 'action', name: 'action'},
                    ],
                    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        // console.log(nRow);
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
        }
    });


    function complete(id) {

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
            
         var table = $("#kasbonTable").DataTable();
         var date = $(`#success${id}`).attr('data-date');
         var name = $(`#success${id}`).attr('data-name');
         var nominal = $(`#success${id}`).attr('data-nominal');
         var desc = $(`#success${id}`).attr('data-desc');
        console.log(nominal);
        console.log(date);
        console.log(desc);

        function formatRupiah(money) {
            return new Intl.NumberFormat('id-ID',
              { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 } // diletakkan dalam object
            ).format(money);
        }


        swal({
            title: "Anda yakin akan menyelesaikan kasbon?",
            text: `Kasbon ${name} - ${desc} (${formatRupiah(nominal)}) - ${date}`,
            icon: "info",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                type: "post",
                url: `/kasbon/complete/${id}`,
                data: {
                    id: id,
                },
                dataType: "json",
                success: function (response) {
                    table.draw();
                    swal("Anda Berhasil Menyelesaikan Kasbon!", {
                      icon: "success",
                    });
                }
            });
          } else {
            swal("Anda membatalkan proses!");
          }
        });
    }

    function reject(id) {

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
            
         var table = $("#kasbonTable").DataTable();
         var date = $(`#reject${id}`).attr('data-date');
         var name = $(`#reject${id}`).attr('data-name');
         var nominal = $(`#reject${id}`).attr('data-nominal');
         var desc = $(`#reject${id}`).attr('data-desc');
        console.log(nominal);
        console.log(date);
        console.log(desc);

        function formatRupiah(money) {
            return new Intl.NumberFormat('id-ID',
              { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 } // diletakkan dalam object
            ).format(money);
        }


        swal({
            title: "Anda yakin akan Menolak kasbon?",
            text: `Kasbon ${name} - ${desc} (${formatRupiah(nominal)}) - ${date}`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
                type: "post",
                url: `/kasbon/reject/${id}`,
                data: {
                    id: id,
                },
                dataType: "json",
                success: function (response) {
                    table.draw();
                    swal("Anda Berhasil Menolak Kasbon!", {
                      icon: "success",
                    });
                }
            });
          } else {
            swal("Anda membatalkan proses!");
          }
        });
    }

</script>
@endsection