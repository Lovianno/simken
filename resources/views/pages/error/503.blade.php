@extends('layouts.app')

@section('title', '503 Service Unavailable')

@section('content')
	<div class="container d-flex flex-column align-items-center justify-content-center py-5" style="min-height: 70vh">
		<h1 class="display-3 fw-bold text-app-primary mb-2">503</h1>
		<h2 class="h4 fw-semibold mb-3">Sedang Maintenance</h2>
		<p class="mb-4 text-secondary">Maaf, website sedang dalam perawatan. Silakan coba beberapa saat lagi.</p>
	</div>
@endsection
