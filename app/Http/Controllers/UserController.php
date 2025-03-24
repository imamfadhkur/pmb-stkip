<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'users';
        $level = $request->input('level');
        $users = User::when($level && $level != 'semua', function ($query) use ($level) {
            return $query->where('level', $level);
        })->latest()->paginate(10);

        return view('dashboard.user.index', compact('users', 'level', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user.create', [
            'title' => 'create user',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari user
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'level' => 'required'
        ]);

        // Buat instance model user baru
        $user = new User;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->level = $validatedData['level'];

        // Simpan instance model ke dalam database
        $user->save();

        // Redirect ke halaman index jalur masuk dengan pesan sukses
        return redirect()->route('user.index')->with('messageSuccess', 'User baru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.user.edit', [
            'title' => 'create user',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->password !== null) {
            $user->update($request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'level' => 'required'
            ]));
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        } else {
            $user->update($request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'level' => 'required'
            ]));
        }
        return redirect()->route('user.index')->with('messageSuccess', 'Data berhasil diedit');
    }
    
    public function reset_password(User $user)
    {
        $user->update([
            'password' => bcrypt(explode('@', $user->email)[0])
        ]);
        return redirect()->route('user.index')->with('messageSuccess', 'Data berhasil diedit, password = username email');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('messageSuccess', 'User berhasil dihapus');
    }
    
    public function sort(Request $request)
    {
        $level = $request->query('level');
        if ($level === 'semua') {
            return redirect('/user');
        }

        $users = User::where('level', $level)
                    ->orderBy($request->query('sort', 'name'), $request->query('ascdesc', 'asc'))
                    ->paginate(17);

        // $users = $users->paginate(17, ['*'], 'page', $request->query('page'));

        $users->appends(['level' => $level, 'sort' => $request->query('sort'), 'ascdesc' => $request->query('ascdesc')]);

        return view('dashboard.user.index', [
            'users' => $users,
            'title' => 'users',
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $level = $request->input('level'); // Anda mungkin ingin mempertimbangkan filter level juga

        $users = User::query()
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', '%' . $query . '%')
                         ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->when($level && $level != 'semua', function ($q) use ($level) {
                return $q->where('level', $level);
            })
            ->latest()
            ->paginate(10); // Anda bisa menyesuaikan jumlah per halaman

        return view('dashboard.user.user_table_data', compact('users'))->render();
    }
}
