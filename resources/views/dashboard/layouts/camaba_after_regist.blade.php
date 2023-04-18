@if (Auth::user()->register->bukti_pembayaran !== null)
    <p>
        Terimakasih telah melakukan pembayaran, silahkan menunggu maksimal 4x24jam untuk admin memverifikasi pembayaran anda. Lalu login kembali untuk mendapatkan informasi lebih lanjut.
    </p>
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
    <form action="/upload-bukti-pembayaran-regist" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="bukti_pembayaran" class="form-label text-danger">Upload Bukti Pembayaran*</label>
        <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran')
            is-invalid
        @enderror">
        @error('bukti_pembayaran')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        <input type="submit" value="upload" class="btn btn-primary my-2">
    </form>
    <p>
        Jika sudah membayar silahkan menunggu maksimal 4x24jam untuk admin memverifikasi pembayaran anda.
    </p>
@endif