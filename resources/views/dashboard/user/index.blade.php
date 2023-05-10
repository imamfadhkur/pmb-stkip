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
    <div style="display: flex; align-items: center">
        <a style="margin-right: auto; margin-bottom: 0;" href="/user/create" class="btn btn-primary mb-2"><i class="bi bi-plus-square"></i> Tambah User</a>
        <form style="margin-left: auto; margin-bottom: 0;" action="/user-sort" method="GET" class="m-2">
            <label for="level">Tampilkan: </label>
            <select id="level" name="level" class="me-1">
            <option value="semua" {{ request('level') == 'semua' ? 'selected' : '' }}>semua</option>
            <option value="camaba" {{ request('level') == 'camaba' ? 'selected' : '' }}>camaba</option>
            <option value="admin" {{ request('level') == 'admin' ? 'selected' : '' }}>admin</option>
            <option value="superadmin" {{ request('level') == 'superadmin' ? 'selected' : '' }}>superadmin</option>
            </select>
            <button type="submit" class="btn btn-sm text-light" style="background-color: #007bff"><i class="bi bi-filter"></i></button>
        </form>       
    </div>
    <table class="table table-hover">
        <tr>
            <th></th>
            <th>Nama</th>
            <th>Email</th>
            <th>Level</th>
            <th>Action</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->level }}</td>
                <td style="display: flex; gap: 10px;">
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
                    </form>
                    <a href="{{ route('user.reset_password', $user->id) }}" class="btn btn-warning btn-sm" title="Reset password" onclick="return confirm('Apakah anda yakin ingin mereset password?')"><i class="bi bi-key"></i></a>
                </td>                
            </tr>
        @endforeach
    </table>
    <div class="d-flex justify-content-end">
        {{ $users->links() }}
    </div>
    {{-- end content --}}

    </div>
</div>

@endsection