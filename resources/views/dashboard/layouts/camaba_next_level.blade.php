<div class="container mb-5">
    <div class="row">
        @php
            $pendaftar = App\Models\Register::where('user_id', Auth::user()->id)->first();
        @endphp
        @if ($pendaftar->status_diterima == 'diterima')
            <p class="text-success">Selamat, anda diterima di prodi 
                @isset($pendaftar->diterimadi->nama)
                    {{ $pendaftar->diterimadi->nama }}
                @endisset
            </p>
        @endif
        <h3 class="m-2">
            Informasi Terbaru:
        </h3>
        @php
    $informasis = App\Models\Informasi::take(3)->get();
    @endphp
  
    @if ($informasis->isNotEmpty())
        @foreach ($informasis as $informasi)
        <div class="col-sm-1 col-md-2 col-lg-3 col-xl-4">
            <div class="card m-2 p-4">
                @if ($informasi->image !== null)
                    <img class="img-fluid w-150 h-80" src="{{ asset('storage/'.$informasi->image) }}" class="card-img-top" alt="{{ $informasi->title }}">
                @else
                    <img class="img-fluid w-150 h-80" src="https://picsum.photos/200/150?grayscale&random&keyword={{ $informasi->title }}" class="card-img-top" alt="{{ $informasi->title }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $informasi->title }}</h5>
                    <p class="card-text">{!! Str::limit($informasi->content,50) !!}</p>
                    <a href="{{ url('pengumuman/'. $informasi->slug) }}" class="btn btn-primary">Lihat</a>
                </div>
            </div>
        </div>
        @endforeach
    @endif
    </div>
    <div class="row">
        <div class="col">
            <a href="{{ url('pengumuman/index') }}" class="btn btn-primary">Semua Pengumuman</a>
        </div>
    </div>
</div>