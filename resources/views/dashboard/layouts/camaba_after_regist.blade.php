<div class="container my-4">
    <div class="row">
        <div class="col-8">
            @if (Auth::user()->register->bukti_pembayaran !== null)
    <p>
        Terimakasih telah melakukan pembayaran, silahkan menunggu maksimal 3x24jam untuk admin memverifikasi pembayaran anda. Lalu login kembali untuk mendapatkan informasi lebih lanjut. <br> Refresh secara berkala halaman ini. <br>Sembari menunggu sambil lengkapi berkas-berkas yang diminta di halaman profil.
    </p>
@else
    <p>
        @php
            $user_id = Auth::user()->id;
            $register = App\Models\Register::where('user_id', $user_id)->first();
            $biaya = $register->jalurMasuk->biaya;
        @endphp
        Silahkan membayar uang pendaftaran sebesar <b>Rp.{{ number_format($biaya, 0, ',', '.') }}</b> ke rekening berikut ini:
    </p>
    <table class="mb-3">
        <tr>
            <td>Nomor Rekening</td>
            <td>:</td>
            <td>{{ App\Models\Bank::first()->nomor_rekening }}</td>
        </tr>
        <tr>
            <td>Bank</td>
            <td>:</td>
            <td>{{ App\Models\Bank::first()->nama_bank }}</td>
        </tr>
        <tr>
            <td>Nama Account</td>
            <td>:</td>
            <td>{{ App\Models\Bank::first()->nama_pemilik }}</td>
        </tr>
    </table>
    <form action="/upload-bukti-pembayaran-regist" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="bukti_pembayaran" class="form-label text-danger">Upload Bukti Pembayaran* (Harus berupa gambar jenis png/jpg, maks. 5mb)</label>
        <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran')
            is-invalid
        @enderror" required>
        @error('bukti_pembayaran')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <input type="submit" value="upload" class="btn btn-primary my-2">
    </form>
    <p>
        Jika sudah membayar silahkan menunggu maksimal 3x24jam untuk admin memverifikasi pembayaran anda.
    </p>
@endif
        </div>
    </div>
</div>