@forelse ($users as $user)
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
@empty
    <tr>
        <td colspan="5" class="text-center">Tidak ada data yang ditemukan.</td>
    </tr>
@endforelse