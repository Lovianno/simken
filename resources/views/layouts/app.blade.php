<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" type="image/png" href="{{ asset('assets/img/favicon/favicon.ico') }}">
	<link rel="apple-touch-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

	<title>@yield('title', '') - SIMKEN</title>
	@vite(['resources/js/app.js', 'resources/scss/app.scss'])
</head>

<body>
	@include('components.guest.navbar')

	@yield('content')

	@include('components.guest.footer')

	<x-toast />

	@stack('scripts')
	<script>
		if (typeof AOS !== 'undefined' && AOS && typeof AOS.init === 'function') {
			AOS.init();
		}
	</script>
</body>

</html>
