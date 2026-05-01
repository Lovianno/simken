<style>
    .course-card {
        height: 410px;
        /* FIX TINGGI CARD */
        border-radius: 1rem;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* HEADER */
    .course-header {
        height: 200px;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }

    .course-card .card-body {
        flex: 1;
        /* isi sisa tinggi */
        display: flex;
        flex-direction: column;
    }

    .course-card .card-body button {
        margin-top: auto;
        /* dorong ke bawah */
    }

    /* IMAGE WRAPPER */
    .course-image-wrapper {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    /* IMAGE */
    .course-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .course-card-link {
        display: block;
    }

    .course-card {
        height: 410;
        border-radius: 1rem;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.35s ease;
    }

    /* HOVER CARD */
    .course-card-link:hover .course-card {
        transform: translateY(-8px);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.15);
    }

    /* OPTIONAL: sedikit efek di header */
    .course-card-link:hover .course-header {
        filter: brightness(0.95);
    }

    .course-card-link:focus-visible .course-card {
        outline: 3px solid #008080;
    }

    /* BADGE LEVEL (VERTIKAL) */
    .badge-level {
        position: absolute;
        right: -32px;
        top: 20px;
        background: #008080;
        color: #fff;
        padding: 0.35rem 1rem;
        transform: rotate(90deg);
        border-radius: 0.5rem;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    /* BADGE MATERI */
    .badge-material {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: #fff;
        color: #333;
        border-radius: 0.5rem;
        padding: 0.3rem 0.6rem;
        font-size: 0.75rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    /* FOOTER */
    .course-footer {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* USER + PRICE ROW */
    .course-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    /* USER NAME */
    .course-user {
        font-size: 0.9rem;
        font-weight: 500;
        color: #555;
        max-width: 60%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* PRICE */
    .course-price {
        font-weight: 700;
        font-size: 1rem;
        white-space: nowrap;
        color: #111;
    }
</style>

<a href="/kursus/{{ $id }}" class="course-card-link text-decoration-none text-dark d-block">

    <div class="card course-card shadow-sm border-0">
        <!-- IMAGE / HEADER -->
        <div class="course-header">
            <div class="course-image-wrapper">
                <img src="{{ asset('storage/' . $image) }}" alt="{{ $title }}" class="course-image">
            </div>
        </div>

        <!-- BODY -->
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                {{ Str::limit($title, 72, '...') }}
            </h5>

            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small"><i class="bx bi-bookmark-fill me-1"></i>{{ $category }}</div>
                <div class="text-muted small">
                    <i class="bi bi-people-fill me-1"></i>{{ $count }} terjual
                </div>
            </div>

            <div class="mt-auto course-footer">

                <div class="course-meta">
                    <div class="course-user">
                        {{ Str::limit($teacher, 20, '...') }}
                    </div>

                    @if ($owned)
                        <div class="course-price text-app-primary fw-semibold">
                            ✔ Sudah Dimiliki
                        </div>
                    @else
                        <div class="course-price {{ (float) $price === 0.0 ? 'text-app-primary' : 'text-dark' }}">
                            {{ (float) $price === 0.0 ? 'GRATIS' : 'Rp ' . number_format((float) $price, 0, ',', '.') }}
                        </div>
                    @endif

                </div>
                @if ($owned)
                    <button class="btn btn-app-secondary w-100">
                        Lihat Kursus
                    </button>
                @else
                    <a href="/kursus/{{ $id }}">
                        <button class="btn btn-app-secondary w-100">
                            Beli
                        </button>
                    </a>
                @endif
            </div>
        </div>
    </div>
</a>
