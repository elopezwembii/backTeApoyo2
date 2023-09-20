<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function getBlogs(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Obtener el número de registros por página desde la solicitud (10 es el valor predeterminado).
        $page = $request->input('page', 1); // Obtener el número de página desde la solicitud (1 es el valor predeterminado).

        $blogs = Blog::paginate($perPage, ['*'], 'page', $page);

        // Obtener la URL de la página anterior y siguiente (si está disponible).
        $prevPageUrl = $blogs->previousPageUrl();
        $nextPageUrl = $blogs->nextPageUrl();

        return response()->json([
            'data' => $blogs->items(),
            'prev_page_url' => $prevPageUrl,
            'next_page_url' => $nextPageUrl,
            'total' => $blogs->total()
        ]);
    }
}