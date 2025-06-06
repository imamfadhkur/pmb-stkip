@extends('layouts.main')

@section('container')
    <!-- Jumbotron -->
    <div class="jumbotron my-4">
        <h1 class="display-4">Hallo!</h1>
        <p class="lead">Mohon maaf atas ketidaknyamanannya, hubungi admin untuk informasi lebih lanjut</p>
        <hr class="my-4">
        @include('components.error_success')
    </div>
@endsection