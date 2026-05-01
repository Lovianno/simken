@extends('layouts.app')

@section('title', '401 Unauthorized')

@section('content')
	<div class="container d-flex flex-column align-items-center justify-content-center py-5" style="min-height: 70vh">
		<h1 class="display-3 fw-bold text-app-primary mb-2">401</h1>
		<h2 class="h4 fw-semibold mb-3">Tidak Terautentikasi</h2>
		<p class="mb-4 text-secondary">Anda harus login untuk mengakses halaman ini.</p>
	</div>
@endsection
