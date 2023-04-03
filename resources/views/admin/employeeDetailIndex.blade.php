@extends('layouts.admin')

@section('content')
    
<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if ($employee->salary_method === "Harian")
                            <h5 class="card-title">Detail Gajian {{ Str::ucfirst($employee?->users->name) }}</h5>
                        @else
                            <h5 class="card-title">Detail Lemburan, Absen Luar Kota & Hari Minggu {{ Str::ucfirst($employee?->users->name) }}</h5>
                        @endif
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
                                <button class="btn btn-success mb-3 ms-1" type="button" id="download"><i class="fa fa-download" aria-hidden="true"></i></i></button>
                            </div>
                        </div>
                        {{-- @if ($employee->salary_method === "Harian") --}}
                            <div class="table-responsive">
                                <table id="employeeHarianTable" class="display table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Area</th>
                                            <th>Lemburan</th>
                                            <th>{{ $employee->salary_method === "Bulanan" ? "Total Lemburan / Uang Tambahan" : "Total Sehari" }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        {{-- @else
                            <div class="table-responsive">
                                <table id="employeeBulananTable" class="display table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Area</th>
                                            <th>Lemburan</th>
                                            <th>Total Bayaran Hari ini</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        @endif --}}
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
            console.log(`${from_date}, ${to_date}`);
            if (from_date != '' && to_date != '') {
                $("#employeeTable").DataTable().destroy();
                load_data(from_date, to_date);
            } else {
                 toastr.error("Harap isi kedua tanggal tanggal tersebut!");
            }
        });

        $("#refresh").click(function (e) { 
            e.preventDefault();
            $("#from_date").val('');
            $("#to_date").val('');
            $("#employeeTable").DataTable().destroy();
            load_data();
        });

        function load_data(from_date = '', to_date = '') {
            $("#employeeHarianTable").DataTable({
                  processing: true,
                  serverSide: false,  
                  filter: true,
                  // responsive: true,
                  searching: true,
                  // scrollX: true,
                  scrollCollapse: true,
                  destroy: true,
                  ajax: {
                      type: "GET",
                      url: "/pegawai/harian/detail/json/"+id+"",
                      data: {
                        id: id,
                        from_date: from_date,
                        to_date: to_date,
                      },
                  },
                  columns: [
                      {data: 'DT_RowIndex', name: '#'},
                      {data: 'date', name: 'date'},
                      {data: 'area', name: 'area'},
                      {data: 'overtime', name: 'overtime'},
                      {data: 'total_salary', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
                  ]
              });
        }

        // function load_data(from_date = '', to_date = '') {
        //     $("#employeeBulananTable").DataTable({
        //           processing: true,
        //           serverSide: false,  
        //           filter: true,
        //           // responsive: true,
        //           searching: true,
        //           // scrollX: true,
        //           scrollCollapse: true,
        //           ajax: {
        //               type: "GET",
        //               url: "/pegawai/bulanan/detail/json/"+id+"",
        //               data: {
        //                 id: id,
        //                 from_date: from_date,
        //                 to_date: to_date,
        //               },
        //           },
        //           columns: [
        //               {data: 'DT_RowIndex', name: '#'},
        //               {data: 'date', name: 'date'},
        //               {data: 'area', name: 'area'},
        //               {data: 'overtime', name: 'overtime'},
        //               {data: 'salary', name: 'salary'},
        //           ]
        //       });
        // }
        
        $("#download").click(function (e) { 
            e.preventDefault();
            
            var employee_id = $("#id").val();
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();

            window.open(`/pegawai/cetak?employee_id=${employee_id}&from_date=${from_date}&to_date=${to_date}`);
        });

    });
</script>

@endsection