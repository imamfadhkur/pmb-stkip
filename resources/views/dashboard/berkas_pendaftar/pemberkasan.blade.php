@extends('layouts.main')
@section('container')

<div class="container text-center my-4">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col">
            <table class="table" style="border-collapse: separate; border-spacing: 10px">
                <form action="/simpan-pemberkasan" enctype="multipart/form-data" method="POST">
                    @csrf
                    <tr>
                        <td colspan="3">
                            @if (isset($berkas->pas_foto_file) && $berkas->pas_foto_file !== null)
                                <img src="{{ asset('storage/'.$berkas->pas_foto_file) }}" alt="foto profil" class="rounded-circle img-thumbnail" style="width: 180px; height: 180px;">  
                                <br>{{ $user->name }}
                            @else
                                <img src="{{ asset('assets/images/temporary-profile.jpg') }}" alt="foto profil" class="rounded-circle img-thumbnail" style="width: 180px; height: 180px;">            
                                <br>{{ $user->name }}
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success mt-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Pas Foto 3*4
                            <br>
                            @if (isset($berkas->pas_foto_file) && $berkas->pas_foto_file !== null)
                                <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->pas_foto_file) }}" download="{{ $berkas->pas_foto }}">{{ $berkas->pas_foto }}</a>
                            @endif
                        </td>
                        <td>:</td>
                        <td><input type="file" name="pas_foto" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>ijazah/skl
                            <br>
                            @if (isset($berkas->ijazah_skl_file) && $berkas->ijazah_skl_file !== null)
                                <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->ijazah_skl_file) }}" download="{{ $berkas->ijazah_skl }}">{{ $berkas->ijazah_skl }}</a>
                            @endif
                        </td>
                        <td>:</td>
                        <td><input type="file" name="ijazah_skl" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>SKHUN
                            <br>
                            @if (isset($berkas->skhun_file) && $berkas->skhun_file !== null)
                                <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->skhun_file) }}" download="{{ $berkas->skhun }}">{{ $berkas->skhun }}</a>
                            @endif
                        </td>
                        <td>:</td>
                        <td><input type="file" name="skhun" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>KK 
                            <br>
                            @if (isset($berkas->kk_file) && $berkas->kk_file !== null)
                                <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->kk_file) }}" download="{{ $berkas->kk }}">{{ $berkas->kk }}</a>
                            @endif
                        </td>
                        <td>:</td>
                        <td><input type="file" name="kk" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>KTP 
                            <br>
                            @if (isset($berkas->ktp_file) && $berkas->ktp_file !== null)
                                <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->ktp_file) }}" download="{{ $berkas->ktp }}">{{ $berkas->ktp }}</a>
                            @endif
                        </td>
                        <td>:</td>
                        <td><input type="file" name="ktp" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Akta Kelahiran 
                            <br>
                            @if (isset($berkas->akta_file) && $berkas->akta_file !== null)
                                <a style="color: blue; text-decoration: none" href="{{ asset('storage/'.$berkas->akta_file) }}" download="{{ $berkas->akta }}">{{ $berkas->akta }}</a>
                            @endif
                        </td>
                        <td>:</td>
                        <td><input type="file" name="akta" class="form-control"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-start">
                            <i class="text-danger">*Jika sudah mengisi dan ada preview file yang bisa di download, MOHON untuk TIDAK di upload ulang KECUALI salah file.</i> <br><br>
                            <a href="/pemberkasan" class="btn btn-primary">Refresh</a>
                            <input type="submit" class="btn btn-success" value="Simpan">
                        </td>
                    </tr>
                </form>
            </table>
        </div>
    </div>
</div>


@endsection