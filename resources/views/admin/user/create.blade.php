@extends('admin.layouts.after-login-layout')
@section('title', 'Admin| Add User')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{$panel_title}}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{$panel_title}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          @if(Session::has('success'))
          <div class="alert alert-success alert-dismissable __web-inspector-hide-shortcut__">
            <span style="color:green;">{{ Session::get('success') }}</span>
          </div>
          @endif
          @if(Session::has('error'))
          <div class="alert alert-danger alert-dismissable">
            <span style="color:red;">{{ Session::get('error') }}</span>
          </div>
          @endif
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">{{$panel_title}}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('admin.add-user.post') }}" enctype="multipart/form-data" id="userAdd" autocomplete="off">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputName">Full Name</label>
                  <input type="text" name="name" id="full_name" value="{{old('name')}}" required class="form-control" placeholder="Full Name">
                  <span style="color:red;">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail">Email</label>
                  <input type="text" name="email" id="email" value="{{old('email')}}" required class="form-control" placeholder="Email">
                  <span style="color:red;">{{ $errors->first('email') }}</span>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <input type="password" name="password" id="password" value="{{old('password')}}" required class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">Confirm Password</label>
                  <input type="password" name="confirm_password" id="confirm_password" value="{{old('confirm_password')}}" required class="form-control" placeholder="Confirm Password">
                </div>
                <!-- <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="exampleInputFile">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text">Upload</span>
                    </div>
                  </div>
                </div> -->
                <!-- <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div> -->
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>
@endsection