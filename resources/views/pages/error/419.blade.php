@extends('layouts.app')

@section('title', '419 Session Expired')

@section('content')
	<div class="container d-flex flex-column align-items-center justify-content-center py-5" style="min-height: 70vh">
		<h1 class="display-3 fw-bold text-app-primary mb-2">419</h1>
		<h2 class="h4 fw-semibold mb-3">Sesi Kadaluarsa</h2>
		<p class="mb-4 text-secondary">Sesi Anda telah kadaluarsa. Silakan refresh halaman atau login kembali.</p>
		<a href="{{ route('beranda') }}" class="btn btn-app-primary btn-lg px-4">
			<i class="bi bi-house-door-fill me-2"></i>Kembali ke Beranda
		</a>
	</div>
@endsection
