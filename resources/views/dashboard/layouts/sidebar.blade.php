<nav id="sidebar">
    <div class="p-4 pt-5">
      <a href="#" class="img logo" style="background-image: url({{ asset('assets/images/logo-stkipbkl.png') }});"></a>
      <p class="mb-2 text-center">welcome, 
        {{-- {{ Auth::user()->role->name }} --}}
        {{ Auth::user()->name }}!</p>
<ul class="list-unstyled components mb-5">
  <li class="{{ Request::is('register') ? 'active' : '' }}">
      <a href="{{ url('register') }}">Pendaftar</a>
  </li>
  <li class="{{ Request::is('api/tagihan') ? 'active' : '' }}">
      <a href="{{ url('api/tagihan') }}">Tagihan</a>
  </li>
  @can('superadmin')
  <li class="{{ Request::is('data') ? 'active' : '' }}">
  <a href="#pageData" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Data Pendaftaran</a>
  <ul class="collapse list-unstyled" id="pageData">
    <li class="{{ Request::is('jenjang-pendidikan') ? 'active' : '' }}">
        <a href="{{ url('jenjang-pendidikan') }}">Jenjang Pendidikan</a>
    </li>
    <li class="{{ Request::is('sistem-kuliah') ? 'active' : '' }}">
        <a href="{{ url('sistem-kuliah') }}">Sistem Kuliah</a>
    </li>
    <li class="{{ Request::is('jalur-masuk') ? 'active' : '' }}">
        <a href="{{ url('jalur-masuk') }}">Jalur Masuk</a>
    </li>
    <li class="{{ Request::is('prodi') ? 'active' : '' }}">
        <a href="{{ url('prodi') }}">Prodi</a>
    </li>
  </ul>
  </li>
  <li>
  <a href="#pageInformasi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Informasi</a>
  <ul class="collapse list-unstyled" id="pageInformasi">
    <li>
        {{-- nanti akan berbentuk seperti post pada blog --}}
        <a href="{{ url('admin-pengumuman') }}">Pengumuman</a>
    </li>
  </ul>
  </li>
  <li class="{{ Request::is('user') ? 'active' : '' }}">
      <a href="{{ url('user') }}">User</a>
  </li>
  <li class="{{ Request::is('setting*') ? 'active' : '' }}">
    <a href="#pageSettings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Settings</a>
    <ul class="collapse list-unstyled" id="pageSettings">
        <li class="{{ Request::is('settings/data-bank') ? 'active' : '' }}">
            <a href="{{ url('settings/data-bank') }}">Data Bank</a>
        </li>
        <li class="{{ Request::is('settings/sosmed') ? 'active' : '' }}">
            <a href="{{ url('settings/sosmed') }}">Sosial Media</a>
        </li>
        <li class="{{ Request::is('settings/informasi-kampus') ? 'active' : '' }}">
            <a href="{{ url('settings/informasi-kampus') }}">Informasi Kampus</a>
        </li>
    </ul>
    </li>
    <li>
        <a href="https://docs.google.com/spreadsheets/d/1XhOh76u4NFFPi9dY9ZFhdrknWhyINu--fQZ4VXxqHv0/edit?usp=sharing" target="_blank">Bug Report</a>
    </li>
  @endcan
</ul>
@if (Auth::user()->level === 'admin')
    <br><br><br>
@endif
<div class="footer mt-5">
    {{-- <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p> --}}
    @if ($informasiKampus->alamat !== null) 
        <div class="d-flex align-items-center mt-2">
            <div class="d-inline"><img class="img" style="max-height: 15px" src="{{ asset('assets/images/logo-stkipbkl.png') }}" alt=""></div>
            <div class="d-inline mt-1 ms-1">{{ $informasiKampus->name }}</div>
        </div>
    @endif
    @if ($informasiKampus->alamat !== null) 
        <div class="d-flex align-items-center mt-2">
            <div class="d-inline"><i class="bi bi-geo-alt"></i></div>
            <div class="d-inline ms-1">{{ $informasiKampus->alamat }}</div>
        </div>
    @endif
    @if ($informasiKampus->email !== null)    
        <div class="d-flex align-items-center mt-2">
            <div class="d-inline"><i class="bi bi-envelope"></i></div>
            <div class="d-inline ms-1">{{ $informasiKampus->email }}</div>
        </div>
    @endif
    @if ($informasiKampus->noTelp !== null)
        <div class="d-flex align-items-center mt-2">
            <div class="d-inline"><i class="bi bi-telephone"></i></div>
            <div class="d-inline ms-1">{{ $informasiKampus->noTelp }}</div>
        </div>
    @endif
    {{-- <p>{{ $informasiKampus->sosial_media }}</p> --}}
</div>

</div>
</nav>