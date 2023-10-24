<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('main-assets/imgs/logo.png') }}" alt="AdminLTE Logo" class="brand-image p-2 elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Ketosin 2023 </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">Beranda</li>
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard', 'dashboard/*') ? 'active' : '' }}">
                        <i class="nav-icon ri-dashboard-line"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/qr-code" class="nav-link {{ Request::is('qr-code', 'qr-code/*') ? 'active' : '' }}">
                        <i class="nav-icon ri-qr-code-line"></i>
                        <p>
                            QR Code
                        </p>
                    </a>
                </li>
                <li class="nav-header">Voting</li>
                <li class="nav-item">
                    <a href="/kandidat" class="nav-link {{ Request::is('kandidat', 'kandidat/*') ? 'active' : '' }}">
                        <i class="nav-icon ri-user-2-line"></i>
                        <p>
                            Kandidat
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pemilihan" class="nav-link {{ Request::is('pemilihan', 'pemilihan/*') ? 'active' : '' }}">
                        <i class="nav-icon ri-signal-tower-line"></i>
                        <p>
                            Pemilihan
                        </p>
                    </a>
                </li>
                <li class="nav-header">Pengguna</li>
                <li class="nav-item">
                    <a href="/peserta" class="nav-link {{ Request::is('peserta', 'peserta/*') ? 'active' : '' }}">
                        <i class="nav-icon ri-user-6-line"></i>
                        <p>
                            Peserta
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kelas" class="nav-link {{ Request::is('kelas', 'kelas/*') ? 'active' : '' }}">
                        <i class="nav-icon ri-bank-line"></i>
                        <p>
                            Kelas
                        </p>
                    </a>
                </li>
                <li class="nav-header">Pengaturan</li>
                <li class="nav-item">
                    <a href="/batas-waktu"
                        class="nav-link {{ Request::is('batas-waktu', 'batas-waktu/*') ? 'active' : '' }}">
                        <i class="nav-icon ri-time-line"></i>
                        <p>
                            Batas Waktu
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/logout" class="nav-link {{ Request::is('logout', 'logout/*') ? 'active' : '' }}">
                        <i class="nav-icon ri-logout-box-line"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
