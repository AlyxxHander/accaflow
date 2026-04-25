<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = User::whereHas('role', function($q) {
            $q->whereIn('name', ['dosen', 'kaprodi']);
        })->latest()->get();

        return view('lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        return view('lecturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|regex:/^[a-zA-Z0-9._%+-]+@webmail\.umm\.ac\.id$/',
            'nidn_nip' => 'required|string|unique:users,nidn_nip',
            'structural_position' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $roleName = ($request->structural_position === 'Kaprodi') ? 'kaprodi' : 'dosen';
        $targetRole = Role::where('name', $roleName)->first();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $targetRole->id,
            'nidn_nip' => $request->nidn_nip,
            'structural_position' => $request->structural_position,
        ]);

        return redirect()->route('lecturers.index')->with('success', 'Akun dosen berhasil dibuat.');
    }

    public function edit(User $lecturer)
    {
        return view('lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, User $lecturer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $lecturer->id . '|regex:/^[a-zA-Z0-9._%+-]+@webmail\.umm\.ac\.id$/',
            'nidn_nip' => 'required|string|unique:users,nidn_nip,' . $lecturer->id,
            'structural_position' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $roleName = ($request->structural_position === 'Kaprodi') ? 'kaprodi' : 'dosen';
        $targetRole = Role::where('name', $roleName)->first();

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $targetRole->id,
            'nidn_nip' => $request->nidn_nip,
            'structural_position' => $request->structural_position,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $lecturer->update($updateData);

        return redirect()->route('lecturers.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(User $lecturer)
    {
        $lecturer->delete();
        return redirect()->route('lecturers.index')->with('success', 'Akun dosen berhasil dihapus.');
    }
}
