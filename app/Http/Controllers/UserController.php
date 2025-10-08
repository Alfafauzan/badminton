<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['index']),
            //         new Middleware('permission:edit users', only: ['edit'])
            //         // new Middleware('permission:create users', only: ['create']),
            //         // new Middleware('permission:delete users', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'ASC')->paginate(10);
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.list', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|exists:roles,id',
            ],
            [
                'name.required' => 'Nama user belum terisi',
                'email.unique' => 'Email user sudah tersedia',
                'name.min' => 'Minimal nama user di atas 3 huruf',
                'email.required' => 'Email user belum terisi',
            ],
        );

        if ($valid->fails()) {
            return redirect()->route('users.create')->withInput()->withErrors($valid);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // Jika kamu butuh password default sementara:
            'password' => bcrypt('password123'),
        ]);

        $user->assignRole(Role::findById($request->role));

        return redirect()->route('users.index')->with('Berhasil', 'Berhasil menambahkan user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRole = $user->roles->pluck('id');
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'hasRole' => $hasRole,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $valid = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
        ]);

        if ($valid->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($valid);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->syncRoles($request->role);
        return redirect()->route('users.index')->with('Berhasil', 'Berhasil ubah users');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);

        if ($user == null) {
            session()->flash('error', 'User tidak di temukan');
            return response()->json([
                'status' => false,
            ]);
        }

        $user->delete();

        session()->flash('Berhasil', 'User berhasil di hapus');
        return response()->json([
            'status' => true,
        ]);
    }
}
