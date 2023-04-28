@extends('layouts.main')
@section('container')

<div class="container my-4">
    <div class="row">
        <div class="col">
            <h3 class="mx-4 mt-2">Jalur Pendaftaran</h3>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="data-diri" method="POST">
                @csrf
                <div class="form-group m-4">
                  <label for="jenjang_pendidikan">Jenjang Pendidikan</label>
                  <select class="form-control" id="jenjang_pendidikan" name="jenjang_pendidikan">
                    @foreach($jenjang_pendidikan as $jp)
                    <option value="{{ $jp->id }}">{{ $jp->nama }}</option>
                    @endforeach
                  </select>
                </div>
              
                <div class="form-group m-4">
                  <label for="sistem_kuliah">Sistem Kuliah</label>
                  <select class="form-control" id="sistem_kuliah" name="sistem_kuliah">
                    @foreach($sistem_kuliah as $sk)
                    <option value="{{ $sk->id }}">{{ $sk->nama }}</option>
                    @endforeach
                  </select>
                </div>
              
                <div class="form-group m-4">
                  <label for="jalur_masuk">Jalur Masuk</label>
                  <select class="form-control" id="jalur_masuk" name="jalur_masuk">
                    @foreach($jalur_masuk as $jm)
                    <option value="{{ $jm->id }}">{{ $jm->nama }}</option>
                    @endforeach
                  </select>
                </div>
              
                <button type="submit" class="btn btn-primary mx-4">Selanjutnya</button>
              </form>              
        </div>
    </div>
</div>

@endsection