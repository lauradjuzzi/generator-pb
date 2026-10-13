<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                'unique:users,username',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'staff'])],
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }


    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                \Illuminate\Validation\Rule::unique('users', 'username')
                    ->ignore($user->id),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],
            'role' => [
                'required',
                \Illuminate\Validation\Rule::in(['admin', 'staff']),
            ],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if ($user->id === Auth::id()) {
            $validated['role'] = $user->role;
        }

        // Password hanya diubah jika kolom diisi.
        if (! empty($validated['password'])) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make(
                $validated['password']
            );
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data akun berhasil diperbarui.');
    }




    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
