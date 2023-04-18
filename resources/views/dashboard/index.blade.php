@extends('layouts.main')
@section('container')

@if (Auth::user()->level == 'camaba')
    @include('dashboard.layouts.camaba')
@else
    @include('dashboard.admin.index')
@endif

@endsection