<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'message' => 'List Semua Kategori',
            'data'    => $categories
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ], 401);
        } else {

            $category = Category::create([
                'title'     => $request->input('title'),
                'content'   => $request->input('content'),
            ]);

            if ($category) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori Berhasil Disimpan!',
                    'data' => $category
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori Gagal Disimpan!',
                ], 400);
            }
        }
    }
    public function show($id)
    {
        $category = Category::find($id);

        if ($category) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Kategori!',
                'data'      => $category
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kategori Tidak Ditemukan!',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Semua Kolom Wajib Diisi!',
                'data'   => $validator->errors()
            ], 401);
        } else {

            $category = Category::whereId($id)->update([
                'title'     => $request->input('title'),
                'content'   => $request->input('content'),
            ]);

            if ($category) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori Berhasil Diupdate!',
                    'data' => $category
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori Gagal Diupdate!',
                ], 400);
            }
        }
    }
    public function destroy($id)
    {
        $category = Category::whereId($id)->first();
        $category->delete();

        if ($category) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori Berhasil Dihapus!',
            ], 200);
        }
    }
}
