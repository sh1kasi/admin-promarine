<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Title -->
        <title>Circl - Responsive Admin Dashboard Template</title>

        <!-- Styles -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
        <link href="{{ asset('template') }}/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('template') }}/plugins/font-awesome/css/all.min.css" rel="stylesheet">
        <link href="{{ asset('template') }}/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">

      
        <!-- Theme Styles -->
        <link href="{{ asset('template') }}/css/main.min.css" rel="stylesheet">
        <link href="{{ asset('template') }}/css/custom.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-page">
        <div class='loader'>
            <div class='spinner-grow text-primary' role='status'>
              <span class='sr-only'>Loading...</span>
            </div>
          </div>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12 col-lg-4">
                    <div class="card login-box-container">
                        <div class="card-body">
                            <div class="authent-logo">
                                <img src="{{ asset('template') }}/images/logo@2x.png" alt="">
                            </div>
                            <div class="authent-text">
                                <p>Welcome to Circl</p>
                                <p>Enter your details to create your account</p>
                            </div>

                            <form action="/register/post" method="post">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control @error('username') is-invalid @enderror " id="floatingInput" placeholder="Fullname">
                                        <label for="floatingInput">Username</label>
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                      </div>
                                </div>
                                {{-- <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="floatingInput1" placeholder="name@example.com">
                                        <label for="floatingInput">Email address</label>
                                      </div>
                                </div> --}}
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                      </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="password" name="password_confirm" class="form-control @error('password_confirm') is-invalid @enderror" id="floatingPassword1" placeholder="Confirm Password">
                                        <label for="floatingPassword">Konfimasi Password</label>
                                        @error('password_confirm')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                      </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary m-b-xs">Register</button>
                                </div>
                              </form>
                              <div class="authent-login">
                                  <p>Sudah memiliki akun? <a href="/login">Masuk</a></p>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         
        
        <!-- Javascripts -->
        <script src="{{ asset('template') }}/plugins/jquery/jquery-3.4.1.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="{{ asset('template') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="{{ asset('template') }}/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
        <script src="{{ asset('template') }}/js/main.min.js"></script>
    </body>
</html>