<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<meta name="ajaxurl" content="{{ url('ajax') }}" />
		<meta name="google-site-verification" content="s4qiuqm16rw9xWRXUOo4TCjTeMOtHubZ0Ui7f0av0qA" />
		<title>{{ $pagetitle }}</title>
		<link rel="profile" href="https://gmpg.org/xfn/11" />
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
		<link rel="stylesheet" href="{{ url('css/font-awesome.css') }}" />
		<link rel="stylesheet" type="text/css" media="all" href="{{ url('css/material-dashboard-pro.min.css') }}">
		<link rel="stylesheet" href="{{ url('css/bootstrap-select.min.css') }}" />
		<link rel="stylesheet" type="text/css" media="all" href="{{ url('style.css') }}?ver=<?php echo time(); ?>" />
		<link rel="stylesheet" type="text/css" media="all" href="{{ url('responsive.css') }}?ver=<?php echo time(); ?>">
		<link rel="shortcut icon" type="image/x-icon" href="{{ url('img/favicon.png') }}">
	</head>
	<body class="{{ $page_class }}">
		<div class="wrapper">
			@if(is_admin_logged_in())
				@include('common.sidebar')
				@php
					$sessionlogindata = json_decode(session()->get('auserdata'));
				@endphp
				<div class="main-panel">
					<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
						<div class="container-fluid">
							<div class="navbar-wrapper">
								<nav aria-label="breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
										@if($pagename != "")
										<li class="breadcrumb-item active" aria-current="page"><a href="{{ url()->current() }}">{{ $pagename }}</a></li>
										@endif
									</ol>
								</nav>
							</div>
							<span class="menu_username">Hi {{ $sessionlogindata->display_name }}</span>
							<button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
								<span class="sr-only">Toggle navigation</span>
								<span class="navbar-toggler-icon icon-bar"></span>
								<span class="navbar-toggler-icon icon-bar"></span>
								<span class="navbar-toggler-icon icon-bar"></span>
							</button>
							@if(url()->current() == url('admin/vidyarthis'))
								@if(($data->sessionlogindata->user_role == 'administrator') || ($data->sessionlogindata->user_role == 'admin'))
									<div class="jpl_btn_padding">
										<ul class="nav flex-column">
											<li class="nav-item">
												<a href="{{ url('admin/vidyarthis/add') }}" class="btn btn-success" role="button" aria-disabled="true"><img class="addvidyarthibtnimg" src="{{ url('img/add-vidyarthi-btn.png') }}" alt="Add Vidyarthi" title=""/> Add Vidyarthi</a>
											</li>
										</ul>
									</div>
								@endif
							@endif
							@if(url()->current() == url('admin/hawans'))
								<div class="jpl_btn_padding">
									<ul class="nav flex-column">
										<li class="nav-item">
											<a href="{{ url('admin/hawans/add') }}" class="btn btn-success" role="button" aria-disabled="true"><img class="addhavanbtnimg" src="{{ url('img/add-havan-btn.png') }}" alt="Add Hawan" title=""/> Add Hawan</a>
										</li>
									</ul>
								</div>
							@endif
							@if(url()->current() == url('admin/admins'))
								<div class="jpl_btn_padding">
									<ul class="nav flex-column">
										<li class="nav-item">
											<a href="{{ url('admin/add') }}" class="btn btn-success" role="button" aria-disabled="true"><img class="addadminbtnimg" src="{{ url('img/addadminbtnimg.png') }}" alt="Add Hawan" title=""/> Add Admin</a>
										</li>
									</ul>
								</div>
							@endif
						</div>
					</nav>
				@endif
