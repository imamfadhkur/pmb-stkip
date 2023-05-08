<nav class="navbar navbar-expand-lg navbar-dark fw-bold p-2 ps-4 pe-4 bg-my-primary">
    <div class="container-fluid">
      
      <!-- Navbar Brand / Logo -->
      <a class="navbar-brand" href="#">
        <table>
          <tr>
            <td rowspan="2"><img src="{{ asset('assets/images/logo-stkipbkl.png') }}" alt="Logo Kampus" width="50" height="50" class="d-inline-block align-text-top me-2"></td>
            <td><h6>Seleksi Penerimaan Mahasiswa Baru</h6></td>
          </tr>
          <tr>
            <td>STKIP PGRI Bangkalan</td>
          </tr>
        </table>
      </a>
      
      <!-- Navbar Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Navbar Menu -->
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">

          @auth
          <!-- Menu Item 1 -->
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">Dashboard</a>
          </li>
          @else
          <!-- Menu Item 1 -->
          <li class="nav-item">
            <a class="nav-link" href="/beranda">Beranda</a>
          </li>
          <!-- Menu Item 2 -->
          <li class="nav-item">
            <a class="nav-link" href="/jalur-pendaftaran">Pendaftaran</a>
          </li>
          @endauth
          
          <!-- Menu Item 3 -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              informasi
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/prodi">Progam Studi</a></li>
              <li><a class="dropdown-item" href="/info-jalur-seleksi">Informasi Jalur Seleksi</a></li>
              @can('auth')
              <li><a class="dropdown-item" href="/pengumuman/index">Pengumumam</a></li>
              @endcan
            </ul>
          </li>
          
        </ul>
      </div>
      
      <!-- Login Button -->
      <div class="d-flex">
        @auth
          <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light ms-2" onclick="return confirm('are you sure?')"><i class="bi bi-box-arrow-right"></i> Logout</button>
          </form>
        @else
          <a class="btn btn-outline-light ms-2" href="/login"><i class="bi bi-box-arrow-left"></i> Login</a>
        @endauth
      </div>
      
    </div>
  </nav>
  