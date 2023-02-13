<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/jvectormap/jquery-jvectormap.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/owl-carousel-2/owl.theme.default.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ URL::asset('admin/assets/css/style.css')}}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ URL::asset('admin/assets/images/favicon.png')}}">
	
		
    @yield('styles')

  </head>
  <!-- END: Head-->
  <body>
    <!-- BEGIN: Side Bar-->
    @include('user.include.sidebar')
    <!-- END: Side Bar-->

    <!-- BEGIN: Header-->
    @include('user.include.header')
    <!-- END: Header-->

    <!-- BEGIN: Page Main-->
	
	
	<!-- Alert Message -->
	
	@if(Session::has('message'))
		<!--<div class="card-alert card card-alert card {{ Session::get('alert-class', 'alert-info') }} ensober_alert"> 
			<div class="card-content white-text">
				<p><i class="material-icons">check</i> {{ Session::get('message') }}.</p>
			</div>
			<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>-->
	@endif
	
	@include('../common.notify')
	<!-- /Alert Message -->
	
    @yield('content')
    <!-- END: Page Main-->

    
    <!-- BEGIN: Footer-->
    {{-- @include('user.include.footer') --}}
    <!-- END: Footer-->
	
    <!-- plugins:js -->
    <script src="{{ URL::asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ URL::asset('admin/assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/vendors/jvectormap/jquery-jvectormap.min.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/vendors/owl-carousel-2/owl.carousel.min.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ URL::asset('admin/assets/js/off-canvas.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/misc.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/settings.js')}}"></script>
    <script src="{{ URL::asset('admin/assets/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ URL::asset('admin/assets/js/dashboard.js')}}"></script>
    <!-- End custom js for this page -->
	@yield('scripts')
  </body>
</html>