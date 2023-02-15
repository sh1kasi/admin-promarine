@extends('layouts.admin')

@section('content')

<div class="page-content">
    <div class="main-wrapper">
        <div class="row">
            <div class="col-md-6 flex">
                <div class="card stat-widget">
                    <div class="card-body pegawai">
                        <h5 class="card-title">Pegawai</h5>
                        <h2>7</h2>
                        <p>Semua Pegawai</p>
                        <div class="progress">
                            <div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 70%"
                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 flex">
                <div class="card stat-widget">
                    <div class="card-body">
                        <h5 class="card-title">Project Terselesaikan</h5>
                        <h2>287</h2>
                        <p>Project yang terselesaikan</p>
                        <div class="progress">
                            <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 flex">
                <div class="card stat-widget">
                    <div class="card-body">
                        <h5 class="card-title">Keuntungan Bulanan</h5>
                        <h2>7.4K</h2>
                        <p>Untuk 1 bulan terakhir</p>
                        <div class="progress">
                            <div class="progress-bar bg-danger progress-bar-striped" role="progressbar"
                                style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 flex">
                <div class="card stat-widget">
                    <div class="card-body">
                        <h5 class="card-title">Project yang Berjalan</h5>
                        <h2>87</h2>
                        <p>Project berjalan </p>
                        <div class="progress">
                            <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                                style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (Session::get('success'))
    <script>
        toastr.success("{!! session('success') !!}");
    </script>
@endif

<script>
    $(document).ready(function () {
        $(".pegawai").hover(function () {
            $(this).css('cursor', 'pointer');
        }, function () {
            $(this).css('cursor', 'auto');
        });
        $(".pegawai").click(function (e) {
            e.preventDefault();
            location.href = '/pegawai';
        });
    });

</script>

@endsection
