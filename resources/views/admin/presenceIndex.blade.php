@extends('layouts.admin')

@section('content')


@include('admin.modal.presenceInput')
@include('admin.modal.presenceDetail')

<div class="page-content">
    <div class="main-wrapper">
            @if (auth()->user()->role === 'user')   
            <div class="biodata row">
                {{-- <div class="row"> --}}
                    <div class="col-md-6">
                      <div class="card detail_employee" id="newpage">
                        <div class="card-body">
                          <div class="items d-flex">
                            <div class="content-1">
                                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt=""  width="100">
                            </div>
                            <div class="content-2 mt-3 ms-4">
                                <b class="ms-4 text-light" style="font-size: 22px">Hai, {{ Str::ucfirst(auth()->user()->name) }}</b>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                {{-- </div> --}}
                {{-- <div class="row"> --}}
                    <div class="col-md-6">
                      <div class="card" id="newpage">
                        <div class="card-header">
                          <h5 class="card-title text-center">{{ $now->translatedFormat("j F Y") }}</h5>
                        </div>
                        <div class="card-body">
                          <div class="item-1 d-flex">
                            <div class="justify-content-between">
                                <b>Status Hadir : </b>
                            </div>
                            <div class="justify-content-between">
                                <p class="ps-2">
                                    @if ($presence == null)
                                        -
                                    @else
                                        <span class="badge alert-success">Hadir</span>
                                    @endif
                                </p>
                            </div>
                          </div>
                          <div class="item-2 d-flex">
                            <div class="justify-content-between">
                                <b>Jam Absen : </b>
                            </div>
                            <div class="justify-content-between">
                                <p class="ps-2">{{ $presence == null ? '-' : $presence->created_at->format("h:i:s") }}</p>
                            </div>
                          </div>
                          <div class="item-3 d-flex">
                            <div class="justify-content-between">
                                <b>Area : </b>
                            </div>
                            <div class="justify-content-between">
                                <p class="ps-2">
                                    @if ($presence != null)
                                        @if ($presence->area == 1)
                                            Area Gerbang Kertasusila
                                        @elseif ($presence->area == 2)
                                            Area Pulau Jawa selain Gerbang Kertasusila
                                        @elseif ($presence->area == 3)
                                            Area Luar Pulau Jawa selain Bangkalan
                                        @elseif ($presence->area == 4)
                                            Area Offshore / Anchorage
                                        @endif
                                    @else
                                        -     
                                    @endif
                                </p>
                            </div>  
                          </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn-success w-100 btn {{ auth()->user()->role === "admin" ? 'd-none' : '' }}" type="button" id="inputPresence" data-bs-toggle="modal" data-bs-target="#inputPresence">Absen</button>
                        </div>
                      </div>
                    </div>
                {{-- </div> --}}
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ auth()->user()->role != 'admin' ? 'Riwayat ' : '' }}Absensi</h5>

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

                        <div class="table-responsive">
                            <table id="employeeTable" class="display table table-bordered pt-3" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th class="">Area</th>
                                        <th>{{ auth()->user()->role === 'admin' ? 'Cek Kehadiran' : 'Status' }}</th>
                                        <th class="{{ auth()->user()->role === "admin" ? 'd-none' : '' }}">Aksi</th>
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

<input type="hidden" id="role" value="{{ auth()->user()->role }}">

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
            var role = $("#role").val();

            if (role === "admin") {
                var isAdmin = false;
            } else {
                var isAdmin = true;
            }
            $("#employeeTable").DataTable({
                processing: true,
                serverSide: true,
                filter: true,
                // responsive: true,
                searching: true,
                
                ajax: {
                    type: "GET",
                    url: "/kehadiran/json",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                    }
                },
                columns: [
                            {data: 'DT_RowIndex', name: '#'},
                            {data: 'date', name: 'date'},
                            // if (role != "admin") {
                                // }
                                {data: 'area', name: 'area', visible: isAdmin},
                                {data: 'action', name: 'action',},
                            // if (role != "admin") {
                                {data: 'action2', name: 'action2', visible: isAdmin},
                            // }
                        ],
                // fnrow,              
                // "columnDefs" : [
                //     {'visible': false, 'targets' : [2]},
                //     {'visible': false, 'targets' : [3]},
                // ],
            });
        }

    });

</script>

@endsection