<!doctype html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<title>@yield('title', Config::get('custom.title'))</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="/assets/css/main.css">

	@yield('header')

	<!--[if lt IE 10]>
	<script src="/assets/js/modernizr.js"></script>
	<![endif]-->
</head>
<body>
	<!--[if lt IE 10]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->

	@include('partials/navbar')

	<div class="container-fluid">
		<div class="row">

			@include('partials.sidebar')

			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

				@yield('content')

			</div>

		</div>
	</div>

	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/bootstrap.min.js"></script>
	@yield('footer')
</body>
</html>
