<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\CategoriaBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class BlogsController extends Controller
{
   // Función para obtener los primeros 6 registros de la tabla blogs
   public function getFirstSixBlogs(int $id)
   {
       $categoryId = $id;    
       $firstSixBlogs = Blog::with('categoria')
           ->when($categoryId, function ($query) use ($categoryId) {
               if ($categoryId == 1) {
                   // Si el ID de categoría es 1, obtén todos los blogs sin filtrar por categoría
                   return $query;
               } else {
                   // Si se proporciona un ID de categoría diferente de 1, filtra por ese ID
                   return $query->where('categoria_id', $categoryId);
               }
           })
           ->orderBy('created_at', 'desc')
           ->limit(6)
           ->get();
   
       return response()->json([
           'data' => $firstSixBlogs
       ]);
   }
   
   public function getBlogs($id = 1)
   {
       $perPage = request()->input('per_page', 10);
       $page = request()->input('page', 1);
   
       // Obtén los IDs de los primeros 6 registros
       $firstSixIds = Blog::limit(6)->pluck('id');
   
       // Utiliza los IDs para obtener los registros restantes, ordenados por fecha de creación descendente.
       $blogs = Blog::whereNotIn('id', $firstSixIds)
           ->when($id, function ($query) use ($id) {
               if ($id == 1) {
                   // Si el ID de categoría es 1, obtén todos los blogs sin filtrar por categoría
                   return $query;
               } else {
                   // Si se proporciona un ID de categoría diferente de 1, filtra por ese ID
                   return $query->where('categoria_id', $id);
               }
           })
           ->with('categoria') // Cargar la relación 'categoria'
           ->orderBy('created_at', 'desc') // Ordenar por fecha de creación descendente
           ->paginate($perPage, ['*'], 'page', $page);
   
       $prevPageUrl = $blogs->previousPageUrl();
       $nextPageUrl = $blogs->nextPageUrl();
   
       $currentPageUrl = url()->current() . "?page=" . $page;
   
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