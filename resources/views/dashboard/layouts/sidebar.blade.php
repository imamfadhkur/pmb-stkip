<nav id="sidebar">
    <div class="p-4 pt-5">
      <a href="#" class="img logo" style="background-image: url({{ asset('assets/images/logo-stkipbkl.png') }});"></a>
      <p class="mb-2 text-center">welcome, 
        {{-- {{ Auth::user()->role->name }} --}}
        {{ Auth::user()->name }}!</p>
<ul class="list-unstyled components mb-5">
  <li class="{{ Request::is('register') ? 'active' : '' }}">
      <a href="/register">Pendaftar</a>
  </li>
  <li class="{{ Request::is('data') ? 'active' : '' }}">
  <a href="#pageData" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Data Pendaftaran</a>
  <ul class="collapse list-unstyled" id="pageData">
    <li class="{{ Request::is('jenjang-pendidikan') ? 'active' : '' }}">
        <a href="#">Jenjang Pendidikan</a>
    </li>
    <li class="{{ Request::is('sistem-kuliah') ? 'active' : '' }}">
        <a href="#">Sistem Kuliah</a>
    </li>
    <li class="{{ Request::is('jalur-masuk') ? 'active' : '' }}">
        <a href="#">Jalur Masuk</a>
    </li>
    <li class="{{ Request::is('prodi') ? 'active' : '' }}">
        <a href="#">Prodi</a>
    </li>
  </ul>
  </li>
  <li>
  <a href="#pageInformasi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Informasi</a>
  <ul class="collapse list-unstyled" id="pageInformasi">
    <li>
        {{-- nanti akan berbentuk seperti post pada blog --}}
        <a href="#">Pengumuman</a>
    </li>
    <li>
        {{-- akan berbentuk seperti post juga, namun hanya terdapat satu saja, dan diletakkan di top of content hompage --}}
        <a href="#">Informasi Pendaftaran</a>
    </li>
  </ul>
  </li>
  @can('superadmin')
  <li class="{{ Request::is('admin') ? 'active' : '' }}">
      <a href="/admin">Admin</a>
  </li>
  <li class="{{ Request::is('setting*') ? 'active' : '' }}">
  <a href="#pageSettings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Settings</a>
  <ul class="collapse list-unstyled" id="pageSettings">
    <li class="{{ Request::is('settings/data-bank') ? 'active' : '' }}">
        <a href="/settings/data-bank">Data Bank</a>
    </li>
    <li class="{{ Request::is('footer') ? 'active' : '' }}">
        <a href="/settings/footer">Footer</a>
    </li>
  </ul>
  </li>
  @endcan
</ul>

<div class="footer">
    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
</div>

</div>
</nav>