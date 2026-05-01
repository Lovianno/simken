@php
	$toastTypes = [
	    'success' => ['label' => config('app.name'), 'color' => '#1db954'], // hijau solid (seperti gambar)
	    'error' => ['label' => config('app.name'), 'color' => '#d42525'], // merah solid
	    'info' => ['label' => config('app.name'), 'color' => '#2196f3'], // biru solid (seperti gambar)
	];
@endphp

@foreach ($toastTypes as $type => $style)
	@if (session($type))
		<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999">
			<div class="bs-toast toast fade bg-dark" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header text-white" style="background-color: {{ $style['color'] }};">
					<i class="bx bx-bell me-2"></i>
					<div class="me-auto fw-bold">{{ $style['label'] }}</div>
					<small>{{ now()->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</small>
				</div>

				<div class="toast-body text-white pt-2" style="background-color: {{ $style['color'] }};">
					{{ session($type) }}
				</div>
			</div>
		</div>
	@endif
@endforeach

<script>
	document.addEventListener("DOMContentLoaded", function() {
		const toastElList = document.querySelectorAll('.toast');

		toastElList.forEach(function(toastEl) {
			const toast = new bootstrap.Toast(toastEl, {
				autohide: false
			});

			// Animasi masuk
			toastEl.classList.add("animate-in");
			toast.show();

			// Setelah 3 detik, animasi keluar
			setTimeout(() => {
				toastEl.classList.remove("animate-in");
				toastEl.classList.add("animate-out");

				toastEl.addEventListener("animationend", () => {
					toast.hide();
				}, {
					once: true
				});

			}, 3000);
		});
	});
</script>

<style>
	/* Toast wrapper */
	.toast,
	.bs-toast {
		border-radius: 6px !important;
		overflow: visible !important;
	}

	/* Header */
	.toast .toast-header {
		border-top-left-radius: 6px !important;
		border-top-right-radius: 6px !important;
		overflow: visible !important;
	}

	/* Body */
	.toast .toast-body {
		border-bottom-left-radius: 6px !important;
		border-bottom-right-radius: 6px !important;
		overflow: hidden;
	}

	/* Animasi masuk */
	.toast.animate-in {
		animation: slideIn 0.45s ease-out forwards;
	}

	@keyframes slideIn {
		from {
			transform: translateX(120%);
			opacity: 0;
		}

		to {
			transform: translateX(0);
			opacity: 1;
		}
	}

	/* Animasi keluar */
	.toast.animate-out {
		animation: slideOut 1s ease-in forwards;
	}

	@keyframes slideOut {
		from {
			transform: translateX(0);
			opacity: 1;
		}

		to {
			transform: translateX(120%);
			opacity: 0;
		}
	}

	/* Tombol X */
	.toast .btn-close {
		filter: none !important;
		opacity: .50 !important;
	}
</style>
