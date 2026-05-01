@extends('layouts.app')

@section('title', '500 Internal Server Error')

@section('content')
	<div class="container d-flex flex-column align-items-center justify-content-center py-5" style="min-height: 70vh">
		<h1 class="display-3 fw-bold text-app-primary mb-2">500</h1>
		<h2 class="h4 fw-semibold mb-3">Terjadi Kesalahan Server</h2>
		<p class="mb-4 text-secondary">Maaf, terjadi kesalahan pada server kami.<br>Silakan coba beberapa saat lagi.</p>
		<a href="{{ route('beranda') }}" class="btn btn-app-primary btn-lg px-4">
			<i class="bi bi-house-door-fill me-2"></i>Kembali ke Beranda
		</a>
	</div>
@endsection
