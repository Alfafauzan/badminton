<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
        public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only: ['index']),
            // new Middleware('permission:edit permissions', only: ['edit']),
            // new Middleware('permission:create permissions', only: ['create']),
            // new Middleware('permission:delete permissions', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'ASC')->paginate(25);
        return view('permissions.list', [
            'permissions' => $permissions,
        ]);
    }
    // ini metode untuk menampilkan halaman Create Permission
    public function create()
    {
        return view('permissions.create');
    }
    // ini metode untuk menambahkan data ke Database
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ],['name.unique' => 'Nama permissions sudah tersedia', 'name.min'=>'Minimal nama permission di atas 3 huruf']);

        if ($valid->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('Berhasil', 'Permission berhasil di tambah');
        } else {
            return redirect()->route('permissions.index')->withInput()->withErrors($valid);
        }
    }
    // ini metode untuk menampilkan edit di halaman permisiion
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', [
            'permission' => $permission,
        ]);
    }
    // ini metode untuk mengubah permisiion
    public function update($id, Request $request)
    {
        $permission = Permission::findOrFail($id);
        $valid = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $id . ',id',
        ],['name.unique' => 'Nama permissions sudah tersedia', 'name.min'=>'Minimal nama permission di atas 3 huruf']);

        if ($valid->passes()) {
            // Permission::create(['name' => $request->name]);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('Berhasil', 'Permission berhasil di ubah');
        } else {
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($valid);
        }
    }
    // ini metode untuk menghapus permisiion
    public function destroy(Request $request)
    {
        $id = $request->id;
        $permission = Permission::find($id);

        if ($permission == null) {
            session()->flash('error', 'Permission tidak di temukan');
            return response()->json([
                'status' => false,
            ]);
        }

        $permission->delete();

        session()->flash('Berhasil', 'Permission berhasil di hapus');
        return response()->json([
            'status' => true,
        ]);
    }
}
