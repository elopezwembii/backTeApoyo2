<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\CategoriaBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class BlogsController extends Controller
{
   // Función para obtener los primeros 6 registros de la tabla blogs
   public function getFirstSixBlogs()
   {
       $firstSixBlogs = Blog::with('categoria') // Cargar la relación 'categoria'
           ->orderBy('created_at', 'desc') // Ordena por fecha de creación descendente
           ->limit(6)
           ->get();
   
       return response()->json([
           'data' => $firstSixBlogs
       ]);
   }
   
   

   // Función para obtener los registros a partir del séptimo en adelante
   public function getBlogs(Request $request)
   {
       $perPage = $request->input('per_page', 10);
       $page = $request->input('page', 1);
   
       // Obtén los IDs de los primeros 6 registros
       $firstSixIds = Blog::limit(6)->pluck('id');
   
       // Utiliza los IDs para obtener los registros restantes, ordenados por fecha de creación descendente.
       $blogs = Blog::whereNotIn('id', $firstSixIds)
           ->with('categoria') // Cargar la relación 'categoria'
           ->orderBy('created_at', 'desc') // Ordenar por fecha de creación descendente
           ->paginate($perPage, ['*'], 'page', $page);
   
       $prevPageUrl = $blogs->previousPageUrl();
       $nextPageUrl = $blogs->nextPageUrl();
   
       $currentPageUrl = $request->url() . "?page=" . $page;
   
       return response()->json([
           'data' => $blogs->items(),
           'prev_page_url' => $prevPageUrl,
           'next_page_url' => $nextPageUrl,
           'current_page_url' => $currentPageUrl,
           'total' => $blogs->total()
       ]);
   }
   
   

   public function crearBlogs(Request $request)
   {
       // Valida los datos del formulario
       $request->validate([
           'title' => 'required',
           'content' => 'required',
           'imageUrl' => 'required',
           'date' => 'required',
           'categoria_id' => 'required', // Agrega validación para la categoría
       ]);

       // Crea el blog con la categoría
       $blog = Blog::create([
           'title' => $request->title,
           'content' => $request->content,
           'imageUrl' => $request->imageUrl,
           'date' => $request->date,
           'categoria_id' => $request->categoria_id, // Asocia el blog con la categoría
       ]);

       // Guarda el blog en la base de datos
       $blog->save();


       return response()->json([
           'message' => 'Blog Creado'
       ], 200);
   }


   
    public function getCategorias()
    {
        $categorias = CategoriaBlog::all();

        return response()->json([
            'data' => $categorias
        ]);
    }

    
}