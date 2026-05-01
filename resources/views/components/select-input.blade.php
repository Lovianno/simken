@props([
    'id', // id unik untuk komponen
    'label', // label dropdown
    'name', // nama input hidden
    'options' => [], // array opsi
    'placeholder' => null, // placeholder tombol
    'disabled' => false, // disable dropdown
    'dropdownClass' => '', // custom class
    'buttonClass' => '', // custom class
    'ulClass' => '', // custom class
    'selected' => null, // value terpilih
    'searchable' => true, // dropdown searchable
    'required' => false, // required input
])
<div class="dropdown {{ $dropdownClass }}">
	<button id="btn-{{ $id }}" class="form-control text-start {{ $buttonClass }}"
		style="background-color: #fff; border: 1px solid #d9dee3; border-radius: 0.375rem; min-height: 38px; padding: 0.375rem 0.75rem; display: flex; align-items: center; justify-content: space-between;"
		data-bs-toggle="dropdown" @if ($disabled) disabled @endif type="button">
		<span class="dropdown-label">
			{{ $selected && isset($options[$selected]) ? $options[$selected] : $placeholder ?? 'Pilih ' . $label }}
		</span>
		<span class="ms-2" style="pointer-events:none;">
			<i class="bx bx-chevron-down fs-5 align-middle"></i>
		</span>
	</button>
	<ul class="dropdown-menu w-100 shadow-sm {{ $ulClass }}" id="dropdown-{{ $id }}"
		style="border-radius: 0.375rem;">
		@if ($searchable)
			<li class="px-2 py-1">
				<input type="text" class="form-control" style="min-height:38px; padding:0.375rem 0.75rem; font-size:1rem;"
					placeholder="Cari {{ strtolower($label) }}..." id="search-{{ $id }}">
			</li>
			<li>
				<hr class="dropdown-divider">
			</li>
		@endif

		<div id="list-{{ $id }}" style="max-height:150px; overflow-y:auto;">

			@forelse($options as $key => $value)
				<li>
					<a class="dropdown-item py-1" data-value="{{ $key }}">
						{{ $value }}
					</a>
				</li>
			@empty
				<li class="no-data-message"><span class="dropdown-item-text text-muted">Tidak ada data bro</span></li>
			@endforelse
		</div>
	</ul>
	<input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $selected }}"
		@if ($required) required @endif>
	<div id="error-{{ $id }}" class="invalid-feedback" style="display:none;">
		{{ $label }} wajib dipilih.
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {

		function attachEventItems() {
			document.querySelectorAll("#list-{{ $id }} .dropdown-item").forEach(item => {
				item.addEventListener("click", function() {
					const value = this.getAttribute("data-value");
					const hiddenInput = document.getElementById("{{ $id }}");
					const button = document.getElementById("btn-{{ $id }}");
					hiddenInput.value = value;
					button.querySelector('.dropdown-label').textContent = this.textContent;
					button.classList.remove('is-invalid');
					hiddenInput.dispatchEvent(new Event('change'));
				});
			});
		}

		attachEventItems(); // panggil awal

		// Search
		@if ($searchable)
			const searchInput = document.getElementById("search-{{ $id }}");

			searchInput.addEventListener("input", function() {
				const keyword = this.value.toLowerCase();
				const items = document.querySelectorAll("#list-{{ $id }} .dropdown-item");
				let found = false;
				items.forEach(item => {
					const text = item.textContent.toLowerCase();
					const match = text.includes(keyword);
					item.style.display = match ? "" : "none";
					if (match) found = true;
				});
				const noDataMsg = document.querySelector('#list-{{ $id }} .no-data-message');
				if (!found) {
					if (!noDataMsg) {
						const li = document.createElement('li');
						li.className = 'no-data-message';
						li.innerHTML =
							'<span class="dropdown-item-text text-muted">Tidak ada data yang sesuai</span>';
						document.getElementById('list-{{ $id }}').appendChild(li);
					}
				} else {
					if (noDataMsg) noDataMsg.remove();
				}
			});
		@endif

		// Validasi required saat submit form
		if ({{ $required ? 'true' : 'false' }}) {
			const form = document.getElementById("{{ $id }}").closest('form');
			if (form) {
				form.addEventListener('submit', function(e) {
					const hiddenInput = document.getElementById("{{ $id }}");
					const button = document.getElementById("btn-{{ $id }}");
					const errorDiv = document.getElementById("error-{{ $id }}");
					if (!hiddenInput.value.trim()) {
						button.classList.add('is-invalid');
						button.style.borderColor = '#dc3545';
						errorDiv.style.display = '';
						e.preventDefault();
					} else {
						button.classList.remove('is-invalid');
						button.style.borderColor = '#d9dee3';
						errorDiv.style.display = 'none';
					}
				});
			}
		}
	});
</script>
