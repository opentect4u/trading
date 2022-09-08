<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/font-awesome.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/apps.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/apps_inner.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/res.css') }}">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!--font-family: 'Roboto', sans-serif;-->

    <link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&display=swap" rel="stylesheet">
    <!--font-family: 'Gorditas', cursive;-->



</head>

<body>

    <div class="loginmainDiv">
        <div class="loginBox">
            <div class="adminLogo"><img src="{{ asset('public/images/logoAdmin.png') }}" alt="" /></div>
            <div>
                @if(count($errors)>0)
                <b>These credentials do not match our records.</b>
                @endif
            </div>
            <div class="fieldSec">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="email" placeholder="Username"
                            name="email">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-lg" id="password"
                            placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                            value="Login">
                    </div>

                    <!-- <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input">
                                Keep me signed in
                            </label>
                        </div>
                        <a href="#" class="auth-link text-black">Forgot password?</a>
                    </div>
                    <div class="mb-2">
                        <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                            <i class="mdi mdi-facebook mr-2"></i>Connect using facebook
                        </button>
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                        Don't have an account? <a href="register.html" class="text-primary">Create</a>
                    </div> -->

                    <div class="text-center mt-4 font-weight-light">
                        <a href="#" class="text-primary">Forgot password?</a>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/main_javascript.js') }}"></script>
    <script src="{{ asset('public/js/main_jquery.js') }}"></script>
</body>

</html>