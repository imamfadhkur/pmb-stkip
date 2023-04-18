<div class="container my-3">
    <div class="row">
        <div class="col-8">
            <h1 class="mb-5">Selamat datang, {{ Auth::user()->name }}</h1>
            
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            
            @if (Auth::user()->change_pw === 'belum')
                @include('dashboard.layouts.change_pw')
            @else
            
            <p>
                Silahkan membayar uang pendaftaran sebesar <b>Rp. xxx.xxx,xx</b> ke rekening berikut ini:
            </p>
            <table class="mb-3">
                <tr>
                    <td>Nomor Rekening</td>
                    <td>:</td>
                    <td>180xxx.xxxx.xxxx</td>
                </tr>
                <tr>
                    <td>Bank</td>
                    <td>:</td>
                    <td>B**</td>
                </tr>
                <tr>
                    <td>Nama Account</td>
                    <td>:</td>
                    <td>STKIP PGRI Bangkalan</td>
                </tr>
            </table>
            <p>
                Jika sudah membayar silahkan menunggu maksimal 4x24jam untuk admin mengkonfirmasi pembayaran anda.
            </p>
            
            @endif
            
        </div>
    </div>
</div>