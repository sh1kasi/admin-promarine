<!DOCTYPE html>
{{-- @dd(asset('public')) --}}
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="stacks">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Title -->
        <title>Circl - Responsive Admin Dashboard Template</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
        <script src="{{ asset('template') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <link href="{{ asset('template') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('template') }}/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('template') }}/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
        <link href="{{ asset('template') }}/plugins/apexcharts/apexcharts.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/black-tie/jquery-ui.min.css" integrity="sha512-+Z63RrG0zPf5kR9rHp9NlTMM29nxf02r1tkbfwTRGaHir2Bsh4u8A79PiUKkJq5V5QdugkL+KPfISvl67adC+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap.min.css">

      
        <!-- Theme Styles -->
        <link href="{{ asset('template') }}/css/main.min.css" rel="stylesheet">
        <link href="{{ asset('template') }}/css/custom.css" rel="stylesheet">
        {{-- <link href= "{{ asset('/public/template/css/custom.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('template') }}/css/dark-theme.css" rel="stylesheet"> --}}

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
          <script>
            const token = `{{ csrf_token() }}`;
          </script>

    </head>
    <body>

        <div class="page-container">
            <div class="page-header">
                <nav class="navbar navbar-expand-lg d-flex justify-content-between">
                  <div class="" id="navbarNav">
                    <ul class="navbar-nav" id="leftNav">
                      <li class="nav-item">
                        <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.index') }}">Home</a>
                      </li>
                      {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Help</a>
                      </li> --}}
                    </ul>
                    </div>
                    {{-- <div class="logo">
                      <a class="navbar-brand" href="index.html"></a>
                    </div> --}}
                    <div class="" id="headerNav">
                      <ul class="navbar-nav">
                        {{-- <li class="nav-item dropdown">
                          <a class="nav-link search-dropdown" href="#" id="searchDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="search"></i></a>
                          <div class="dropdown-menu dropdown-menu-end dropdown-lg search-drop-menu" aria-labelledby="searchDropDown">
                            <form>
                              <input class="form-control" type="text" placeholder="Type something.." aria-label="Search">
                            </form>
                            <h6 class="dropdown-header">Recent Searches</h6>
                            <a class="dropdown-item" href="#">charts</a>
                            <a class="dropdown-item" href="#">new orders</a>
                            <a class="dropdown-item" href="#">file manager</a>
                            <a class="dropdown-item" href="#">new users</a>
                          </div>
                        </li> --}}
                        <li class="nav-item dropdown">
                          {{-- <a class="nav-link notifications-dropdown" href="#" id="notificationsDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false">3</a> --}}
                          <div class="dropdown-menu dropdown-menu-end notif-drop-menu" aria-labelledby="notificationsDropDown">
                            <h6 class="dropdown-header">Notifications</h6>
                            <a href="#">
                              <div class="header-notif">
                                <div class="notif-image">
                                  <span class="notification-badge bg-info text-white">
                                    <i class="fas fa-bullhorn"></i>
                                  </span>
                                </div>
                                <div class="notif-text">
                                  <p class="bold-notif-text">faucibus dolor in commodo lectus mattis</p>
                                  <small>19:00</small>
                                </div>
                              </div>
                            </a>
                            <a href="#">
                              <div class="header-notif">
                                <div class="notif-image">
                                  <span class="notification-badge bg-primary text-white">
                                    <i class="fas fa-bolt"></i>
                                  </span>
                                </div>
                                <div class="notif-text">
                                  <p class="bold-notif-text">faucibus dolor in commodo lectus mattis</p>
                                  <small>18:00</small>
                                </div>
                              </div>
                            </a>
                            <a href="#">
                              <div class="header-notif">
                                <div class="notif-image">
                                  <span class="notification-badge bg-success text-white">
                                    <i class="fas fa-at"></i>
                                  </span>
                                </div>
                                <div class="notif-text">
                                  <p>faucibus dolor in commodo lectus mattis</p>
                                  <small>yesterday</small>
                                </div>
                              </div>
                            </a>
                            <a href="#">
                              <div class="header-notif">
                                <div class="notif-image">
                                  <span class="notification-badge">
                                    <img src="{{ asset('template') }}/images/avatars/profile-image.png" alt="">
                                  </span>
                                </div>
                                <div class="notif-text">
                                  <p>faucibus dolor in commodo lectus mattis</p>
                                  <small>yesterday</small>
                                </div>
                              </div>
                            </a>
                            <a href="#">
                              <div class="header-notif">
                                <div class="notif-image">
                                  <span class="notification-badge">
                                    <img src="{{ asset('template') }}/images/avatars/profile-image.png" alt="">
                                  </span>
                                </div>
                                <div class="notif-text">
                                  <p>faucibus dolor in commodo lectus mattis</p>
                                  <small>yesterday</small>
                                </div>
                              </div>
                            </a>
                          </div>
                        </li>
                        <li class="nav-item dropdown">
                          <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{ asset('template') }}/images/avatars/profile-image.png" alt=""></a>
                          <div class="dropdown-menu dropdown-menu-end profile-drop-menu" aria-labelledby="profileDropDown">
                            <p class="ms-3 text-muted
                            ">Hai, {{ Str::ucfirst(auth()->user()->name) }}!</p>
                          <div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="logout()" href="#"><i data-feather="log-out"></i>Logout</a>
                            <form action="/logout" id="logout" method="POST" class="d-none">
                              @csrf
                            </form>
                          </div>
                        </li>
                      </ul>
                  </div>
                </nav>
            </div>
            <div class="page-sidebar">
                <ul class="list-unstyled accordion-menu">
                  <li class="sidebar-title {{ auth()->user()->role == 'user' ? 'd-none' : '' }}">
                    Utama
                  </li>
                  <li class=" {{ auth()->user()->role == 'user' ? 'd-none' : '' }} @if (Route::current()->getName() == 'dashboard.index')
                    active-page
                  @endif">
                    <a href="{{ route('dashboard.index') }}"><i data-feather="home"></i>Dashboard</a>
                  </li>
                  <li class="sidebar-title">
                    Pegawai
                  </li>
                  <li class="mt-1 {{ auth()->user()->role == 'user' ? 'd-none' : '' }} @if (Route::current()->getName() == 'employee.index')
                    active-page
                  @endif">
                    <a href="{{ route('employee.index') }}"><i data-feather="users"></i>Pegawai</a>
                  </li>
                  <li class="mt-1 @if (Route::current()->getName() == 'presence.index')
                    active-page
                  @endif">
                    <a href="{{ route('presence.index') }}"><i data-feather="check-square"></i>Absen Kehadiran</a>
                  </li>
                  <li class="sidebar-title">
                    Lembur
                  </li>
                  <li class="mt-1 {{ auth()->user()->role == 'user' ? 'd-none' : '' }} @if (Route::current()->getName() == 'overtime.index')
                    active-page
                    @endif">
                    <a href="{{ route('overtime.index') }}"><i data-feather="clock"></i>Lemburan</a>
                  </li>
                  <li class="mt-1 @if (Route::current()->getName() == 'overtime.presence')
                    active-page
                  @endif">
                    <a href="{{ route('overtime.presence') }}"><i data-feather="check-circle"></i>Absen Lemburan</a>
                  </li>
                  <li class="sidebar-title">
                    Kasbon
                  </li>
                  @if (auth()->user()->role === 'admin')
                    <li class="mt-1 {{ auth()->user()->role == 'user' ? 'd-none' : '' }} @if (Route::current()->getName() == 'kasbon.admin.index')
                      active-page
                    @endif">
                      <a href="{{ route('kasbon.admin.index') }}"><i data-feather="dollar-sign"></i>Kasbon Pegawai &nbsp; <span class="badge" style="background-color: red; border-radius: 50%; padding: 5px 10px; top: -10px; right: -10px;" id="kasbon_count"></span></a>
                    </li>
                  @else
                    <li class="mt-1 {{ auth()->user()->role == 'admin' ? 'd-none' : '' }} @if (Route::current()->getName() == 'kasbon.user.index')
                      active-page
                    @endif">
                      <a href="{{ route('kasbon.user.index') }}"><i data-feather="dollar-sign"></i>Kasbon</a>
                    </li>
                  @endif
                </ul>
            </div>        
            </div>
        <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

            @yield('content')
        </div>
        
        <!-- Javascripts -->
        <script src="{{ asset('template') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
        <script type="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.3.3/js/dataTables.buttons.min.js" integrity="sha512-8sSGWfEP0O2tSZiaGmlHw9YZ6fKrfVfuC6DG5/URxgL8otfSK6bRDuRp6rO2U+EN3lVKIUBOG9GE8ss3FVJ1vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
        <script type="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('template') }}/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
        <script src="{{ asset('template') }}/plugins/apexcharts/apexcharts.min.js"></script>
        <script src="{{ asset('template') }}/js/main.min.js"></script>
        <script src="{{ asset('template') }}/js/pages/dashboard.js"></script>
        <script>
          function logout() {
            // alert('a')
            event.preventDefault();
            document.getElementById('logout').submit();
          }

          $(document).ready(function () {
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.ajax({
              type: "post",
              url: "/kasbon-count",
              dataType: "json",
              success: function (response) {
                if (response.count == 0) {
                  $("#kasbon_count").addClass(response.count);
                } else {
                  $("#kasbon_count").append(response.count);
                }
              }
            });
          });
          

        </script>
    </body>
</html>