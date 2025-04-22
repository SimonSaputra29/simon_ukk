<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-white"
            href="{{ Auth::check() ? (Auth::user()->role === 'administrator' ? route('admin.index') : (Auth::user()->role === 'petugas' ? route('petugas.index') : route('visitor.index'))) : url('/') }}">
            Perpus Digital
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-4">
                            <li>
                                <a class="dropdown-item text-danger fw-semibold" href="#" onclick="confirmLogout()">
                                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ url('/login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin mau keluar??',
            text: 'Kamu akan keluar dari akun ini.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Keluar',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Keluarr ...',
                    text: 'Tunggu sebentar ya.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        setTimeout(() => {
                            document.getElementById('logout-form').submit();
                        }, 1000);
                    }
                });
            }
        });
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .navbar {
        background-color: #0275d8;
        /* Primary blue */
        padding: 15px 20px;
    }

    .navbar-brand {
        font-size: 1.5rem;
        color: #fff !important;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        filter: brightness(0) invert(1);
    }

    .dropdown-menu {
        border-radius: 8px;
    }

    .nav-link {
        transition: color 0.2s ease-in-out;
    }

    .nav-link:hover {
        color: #fff !important;
        /* Ensure hover text stays white */
        text-decoration: underline;
    }

    .btn {
        transition: all 0.3s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.05);
    }
</style>
