<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Forgot Password</title>

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
    <div class="login-logo">
      <a href="javascript:void(0)"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
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
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

        <form action="{{route('admin.post-forget-password')}}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="resetemail" id="resetemail" placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Request new password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="{{route('admin.login')}}">Login</a>
        </p>
        <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
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