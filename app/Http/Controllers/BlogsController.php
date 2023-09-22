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
       $searchTerm = request()->input('q'); // Obtener el término de búsqueda de la URL
   
       // Obtén los IDs de los primeros 6 registros
       $firstSixIds = Blog::limit(6)->pluck('id');
   
       // Utiliza los IDs para obtener los registros restantes, ordenados por fecha de creación descendente.
       $query = Blog::whereNotIn('id', $firstSixIds)
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
           ->orderBy('created_at', 'desc'); // Ordenar por fecha de creación descendente
   
       // Agregar la búsqueda si se proporciona un término de búsqueda
       if ($searchTerm) {
           $query->where(function ($subquery) use ($searchTerm) {
               $subquery->where('title', 'like', '%' . $searchTerm . '%')
                   ->orWhere('content', 'like', '%' . $searchTerm . '%');
           });
       }
   
       $blogs = $query->paginate($perPage, ['*'], 'page', $page);
   
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
       try {
           // Valida los datos del formulario
           $request->validate([
               'title' => 'required',
               'content' => 'required',
               'imageUrl' => 'required',
               'categoria_id' => 'required',
            ]);
            Log::info($request);
            // Si se proporciona un ID en la solicitud, actualiza el blog existente
            if ($request->has('id') && $request->input('id') !== null) {
                $blog = Blog::findOrFail($request->input('id')); // Encuentra el blog existente
                $blog->update([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'imageUrl' => $request->input('imageUrl'),
                    'categoria_id' => $request->input('categoria_id'),
                ]);
            } else {
                // Si no se proporciona un ID, crea un nuevo blog
                $blog = Blog::create([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'imageUrl' => $request->input('imageUrl'),
                    'categoria_id' => $request->input('categoria_id'),
                ]);
            }
           return response()->json([
               'message' => 'Blog ' . ($request->has('id') ? 'actualizado' : 'creado') . ' con éxito'
           ], 200);
       } catch (\Exception $e) {
           // Manejo de errores en caso de que ocurra una excepción
           return response()->json([
               'error' => 'Error al ' . ($request->has('id') ? 'actualizar' : 'crear') . ' el blog: ' . $e->getMessage()
           ], 500);
       }
   }
 
    public function getCategorias()
    {
        $categorias = CategoriaBlog::all();

        return response()->json([
            'data' => $categorias
        ]);
    }

    public function searchBlogs(Request $request)
{
    $searchTerm = $request->input('q'); // Obtiene los términos de búsqueda del cliente

    // Realiza la búsqueda en la base de datos utilizando los términos de búsqueda
    $results = Blog::where('title', 'LIKE', "%$searchTerm%")
                    ->orWhere('content', 'LIKE', "%$searchTerm%")
                    ->get();

    return response()->json([
        'data' => $results
    ]);
}


    
}