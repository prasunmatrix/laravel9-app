<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Recover Password </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/admin/dist/css/adminlte.min.css')}}">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="javascript:void(0)" class="h1"><b>Admin</b>LTE</a>
      </div>
      <div class="card-body">
        @if(count($errors) > 0)
        <div class="alert alert-danger alert-dismissable" style="text-align: center;">
          <!-- <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> -->
          @foreach ($errors->all() as $error)
          <span>{{ $error }}</span><br />
          @endforeach
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable __web-inspector-hide-shortcut__" style="text-align: center;">
          <!-- <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> -->
          {{ Session::get('success') }}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable" style="text-align: center;">
          <!-- <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> -->
          {{ Session::get('error') }}
        </div>
        @endif
        <p class="login-box-msg">Recover Password</p>

        <form action="{{ route('admin.reset-password') }}" method="post">
          @csrf
          <input type="hidden" name="tok3n" value="{{ $tok3n }}">
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="New Password" name="password" id="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Re-type New Password" name="password_confirmation" id="password_confirmation" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <!-- <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div> -->
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
        <!-- /.social-auth-links -->

        <p class="mb-1">
          <a href="{{ route('admin.login')}}">Back To Login</a>
        </p>
        <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="{{asset('assets/admin/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('assets/admin/dist/js/adminlte.min.js')}}"></script>
</body>

</html>