<!-- Footer -->
<footer class="bg-my-gray-dark py-5 px-5">
  <div class="container">
    <div class="row justify-content-center">
        <div class="col text-md-center">
            @if ($informasiKampus->alamat !== null) 
                <div class="mt-2">
                    <div class="d-inline"><img class="img" style="max-height: 15px" src="{{ asset('assets/images/logo-stkipbkl.png') }}" alt=""></div>
                    <div class="d-inline mt-1 ms-1">{{ $informasiKampus->name }}</div>
                </div>
                <div class="mt-2">
                    <div class="d-inline"><i class="bi bi-geo-alt"></i></div>
                    <div class="d-inline ms-1">{{ $informasiKampus->alamat }}</div>
                </div>
            @endif
            @if ($informasiKampus->email !== null)    
                <div class="mt-2">
                    <div class="d-inline"><i class="bi bi-envelope"></i></div>
                    <div class="d-inline ms-1">{{ $informasiKampus->email }}</div>
                </div>
            @endif
            @if ($informasiKampus->noTelp !== null)
                <div class="mt-2">
                    <div class="d-inline"><i class="bi bi-telephone"></i></div>
                    <div class="d-inline ms-1">{{ $informasiKampus->noTelp }}</div>
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col text-md-center">
            @foreach ($footerSosmed as $sosmed)
            <a href="{{ $sosmed->link }}" class="text-decoration-none m-1 text-light" target="_blank">{!! $sosmed->icon !!}</a>
            @endforeach
        </div>
    </div>
</div>

  </footer>