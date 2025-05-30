<nav class="navbar navbar-expand-lg navbar-dark fw-bold p-2 ps-4 pe-4 bg-my-primary">
    <div class="container-fluid">
      
      <!-- Navbar Brand / Logo -->
      <a class="navbar-brand" href="{{ url('/') }}" style="display: flex; align-items: center;">
        <img src="{{ asset('assets/images/logo-stkipbkl.png') }}" alt="Logo Kampus" width="50" height="50" class="d-inline-block align-text-top me-2">
        <div style="display: flex; flex-direction: column;">
          <h6 style="margin: 0;">Penerimaan Mahasiswa Baru</h6>
          <span style="font-size: 0.8rem;">STKIP PGRI Bangkalan</span>
        </div>
      </a>
      
      <!-- Navbar Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Navbar Menu -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          @auth
          <!-- Menu Item 1 -->
          <li class="nav-item">
            <a class="nav-link" href="{{ url('dashboard') }}">Dashboard</a>
          </li>
          @can('auth')
            <li><a class="nav-link" href="{{ url('pengumuman/index') }}">Pengumumam</a></li>
          @endcan
          @else
          <!-- Menu Item 1 -->
          <li class="nav-item">
            <a class="nav-link" href="{{ url('beranda') }}">Beranda</a>
          </li>
          <!-- Menu Item 2 -->
          <li class="nav-item">
            <a class="nav-link" href="{{ url('jalur-pendaftaran') }}">Pendaftaran</a>
          </li>
          @endauth
          
          <!-- Menu Item 3 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Informasi
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ url('info-prodi') }}">Progam Studi</a></li>
              <li><a class="dropdown-item" href="{{ url('info-jalur-masuk') }}">Informasi Jalur Masuk</a></li>
              @can('auth')
              <li><a class="dropdown-item" href="{{ url('pengumuman/index') }}">Pengumumam</a></li>
              @endcan
            </ul>
          </li>

          @can('auth')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              profil
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ url('profil') }}">data diri</a></li>
              <li><a class="dropdown-item" href="{{ url('pemberkasan') }}">pemberkasan</a></li>
            </ul>
          </li>
          @endcan
          
          <!-- Login Button -->
          @auth
            <form action="{{ url('logout') }}" method="POST" class="ms-2">
              @csrf
              <button type="submit" class="btn btn-outline-light ms-2" onclick="return confirm('are you sure?')"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
          @else
            <a class="btn btn-outline-light ms-2" href="{{ url('login') }}"><i class="bi bi-box-arrow-left"></i> Login</a>
          @endauth
        </ul>
      </div>
      
    </div>
  </nav>
  