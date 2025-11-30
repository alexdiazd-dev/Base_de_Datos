<div class="ms-3">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-lavanda rounded-pill px-4 py-2 d-flex align-items-center shadow-sm">
            <i class="bi bi-box-arrow-right me-2"></i>
            Cerrar sesión
        </button>
    </form>
</div>

