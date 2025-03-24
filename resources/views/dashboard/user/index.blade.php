@extends('layouts.main')
@section('container')

<div class="wrapper d-flex align-items-stretch">
    @include('dashboard.layouts.sidebar')
    <div id="content" class="p-md-3">
        @include('dashboard.layouts.navbar')

        {{-- content --}}
        @if (session('messageSuccess'))
            <div class="alert alert-success">
                {{ session('messageSuccess') }}
            </div>
        @endif
        @if (session('messageError'))
            <div class="alert alert-danger">
                {{ session('messageError') }}
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
            <input type="text" id="searchInput" class="form-control form-control-sm me-2" placeholder="Cari Nama atau Email">
            </div>
            <a href="{{ url('user/create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-square"></i></a>
            <form action="{{ url('user-sort') }}" method="GET" class="d-flex align-items-center">
            @csrf
            <label for="level" class="me-2">Tampilkan: </label>
            <select id="level" name="level" class="form-select form-select-sm me-2">
                <option value="semua" {{ request('level') == 'semua' ? 'selected' : '' }}>semua</option>
                <option value="camaba" {{ request('level') == 'camaba' ? 'selected' : '' }}>camaba</option>
                <option value="admin" {{ request('level') == 'admin' ? 'selected' : '' }}>admin</option>
                <option value="superadmin" {{ request('level') == 'superadmin' ? 'selected' : '' }}>superadmin</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-filter"></i></button>
            </form>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                @include('dashboard.user.user_table_data')
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
        {{-- end content --}}

        </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const userTableBody = document.getElementById('userTableBody');

    searchInput.addEventListener('input', function() {
        let query = this.value;
        fetchUsers(query);
    });

    function fetchUsers(query = '') {
        fetch(`/users/search?query=${query}`)
            .then(response => response.text())
            .then(data => {
                userTableBody.innerHTML = data;
            });
    }
</script>

@endsection