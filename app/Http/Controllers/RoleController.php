<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            // new Middleware('permission:edit roles', only: ['edit']),
            // new Middleware('permission:create roles', only: ['create']),
            // new Middleware('permission:delete roles', only: ['destroy'])
        ];
    }
    // ini untuk menampilkan halaman index berupa list role yang sudah di buat
    public function index()
    {
        $role = Role::orderBy('created_at', 'ASC')->paginate(25);
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.list', [
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }
    // ini metode untuk menampilkan halaman Create Permission
    public function create()
    {
        // buat variable dan isi variabel dengan data pada kolom permission di database
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', [
            'permissions' => $permissions,
        ]);
    }
    // ini metode untuk menambahkan data ke Database
    public function store(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:roles|min:3',
            ],
            [
                'name.required' => 'Isi dong masa kosong',
                'name.unique' => 'Nama role sudah tersedia',
                'name.min' => 'Minimal nama role di atas 3 huruf',
            ],
        );

        if ($valid->passes()) {
            $role = Role::create(['name' => $request->name]);

            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('role.index')->with('Berhasil', 'Permission berhasil di tambah');
        } else {
            return redirect()->route('role.create')->withInput()->withErrors($valid);
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $haspermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.edit', [
            'permissions' => $permissions,
            'haspermissions' => $haspermissions,
            'role' => $role,
        ]);
    }

    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id',
        ],
        [
            'name.required' => 'Isi dong masa kosong','name.unique' => 'Nama role sudah tersedia', 'name.min'=>'Minimal nama role di atas 3 huruf'
        ]);

        if ($valid->passes()) {
            // $role = Role::create(['name' => $request->name]);
            $role->name = $request->name;
            $role->save();

            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }
            return redirect()->route('role.index')->with('Berhasil', 'Role berhasil di ubah');
        } else {
            return redirect()->route('role.create', $id)->withInput()->withErrors($valid);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::find($id);

        if ($role == null) {
            session()->flash('error', 'Permission tidak di temukan');
            return response()->json([
                'status' => false,
            ]);
        }

        $role->delete();

        session()->flash('Berhasil', 'Permission berhasil di hapus');
        return response()->json([
            'status' => true,
        ]);
    }
}
