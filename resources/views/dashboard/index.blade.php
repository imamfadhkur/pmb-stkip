@extends('layouts.main')

@section('container')
    @if (Auth::user()->level == 'camaba')
        {{-- Kita panggil satu file layout terpusat --}}
        @include('dashboard.layouts.camaba')
    @else
        @include('dashboard.pendaftar.index')
    @endif
@endsection