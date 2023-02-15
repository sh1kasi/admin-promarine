@extends('layouts.admin')

@section('content')

@php
    $role = auth()->user()->role;
@endphp

<div class="page-content">
    <div class="main-wrapper home-menu mx-auto" >
        <div class="row">
            <div class="col-md-6 col-xl-3 {{ $role != 'admin' ? 'd-none' : '' }}" onclick="window.location.href = '/dashboard'">
                <div class="card stat-widget">
                    <div class="card-body pegawai">
                        <h5 class="card-title">Menu Dashboard</h5>
                        <h2><i class="fa-solid fa-lg fa-chart-line"></i></h2>
                        <p>Pergi ke manu dashboard</p>
                    </div>
                </div>
            </div>
            @if ($role === 'admin')
            <div class="col-md-6 col-xl-3" onclick="window.location.href = '/pegawai'">
                <div class="card stat-widget">
                    <div class="card-body">
                        <h5 class="card-title">Menu Pegawai</h5>
                        <h2><i class="fa-solid fa-lg fa-user"></i></h2>
                        <p>Pergi ke menu pegawai</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3" onclick="window.location.href = '/lemburan'">
                <div class="card stat-widget">
                    <div class="card-body">
                        <h5 class="card-title">Menu Lemburan</h5>
                        <h2><i class="fa-solid fa-lg fa-clock"></i></h2>
                        <p>Pergi ke menu lemburan</p>
                    </div>
                </div>
            </div>    
            @else
            <div class="col-md-6 col-xl-3" onclick="window.location.href = '/kehadiran'">
                <div class="card stat-widget">
                    <div class="card-body">
                        <h5 class="card-title">Menu Absen Kehadiran</h5>
                        <h2><i class="fa-solid fa-lg fa-user"></i></h2>
                        <p>Pergi ke menu absen kehadiran</p>
                    </div>
                </div>
            </div>     
            <div class="col-md-6 col-xl-3" onclick="window.location.href = '/lemburan/absen'">
                <div class="card stat-widget">
                    <div class="card-body">
                        <h5 class="card-title">Menu Absen Lemburan</h5>
                        <h2><i class="fa-solid fa-lg fa-clock"></i></h2>
                        <p>Pergi ke menu absen lemburan</p>
                    </div>
                </div>
            </div>     
            @endif
        </div>
    </div>
</div>

    
<script>
    $(document).ready(function () {

        // Link


        $(".page-sidebar").addClass('d-none');
        $("#sidebar-toggle").addClass('d-none');
        $(".page-content").css('margin-left', '0');
    });
</script>

@endsection