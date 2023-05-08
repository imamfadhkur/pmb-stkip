<div class="container my-3">
    <div class="row">
        <div class="col-8">
            <h1>Selamat datang, {{ Auth::user()->name }}</h1>
            
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif            
        </div>
    </div>
</div>

@if (Auth::user()->change_pw === 'belum')
    @include('dashboard.layouts.change_pw')
@elseif (Auth::user()->register->pembayaran === 'sudah')
    @include('dashboard.layouts.camaba_next_level')
@else
    @include('dashboard.layouts.camaba_after_regist')
@endif