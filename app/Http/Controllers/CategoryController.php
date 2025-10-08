<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view categories', only: ['index']),
            // new Middleware('permission:edit permissions', only: ['edit']),
            // new Middleware('permission:create permissions', only: ['create']),
            // new Middleware('permission:delete permissions', only: ['destroy'])
        ];
    }
    public function index()
    {
        $categories = Category::orderBy('created_at', 'ASC')->paginate(25);
        return view('category.list', [
            'categories' => $categories,
        ]);
    }
    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        
        $valid = Validator::make($request->all(), [
            'name' => 'required|unique:categories|min:3',
        ]);

        if ($valid->passes()) {
            Category::create(['name' => $request->name]);
            return redirect()->route('categories.index')->with('Berhasil', 'Category berhasil di tambah');
        } else {
            return redirect()->route('categories.index')->withInput()->withErrors($valid);
        }
    }

    public function edit($id)
    {
        $categories = Category::findOrFail($id);
        return view('categories.edit', [
            'categories' => $categories,
        ]);
    }
    // ini metode untuk mengubah permisiion
    public function update($id, Request $request)
    {
        $categories = Category::findOrFail($id);
        $valid = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,' . $id . ',id',
        ]);

        if ($valid->passes()) {
            // Permission::create(['name' => $request->name]);
            $categories->name = $request->name;
            $categories->save();
            return redirect()->route('categories.index')->with('Berhasil', 'Category berhasil di ubah');
        } else {
            return redirect()->route('categories.create')->withInput()->withErrors($valid);
        }
    }
    // ini metode untuk menghapus permisiion
    public function destroy(Request $request)
    {
        $id = $request->id;
        $categories = Category::find($id);

        if ($categories == null) {
            session()->flash('error', 'categories tidak di temukan');
            return response()->json([
                'status' => false,
            ]);
        }

        $categories->delete();

        session()->flash('Berhasil', 'Category berhasil di hapus');
        return response()->json([
            'status' => true,
        ]);
    }
}
