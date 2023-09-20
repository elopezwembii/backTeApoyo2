<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
   // Función para obtener los primeros 6 registros de la tabla blogs
   public function getFirstSixBlogs()
   {
       $firstSixBlogs = Blog::limit(6)->get();

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
   
       // Utiliza los IDs para obtener los registros restantes y luego paginate el resultado.
       $blogs = Blog::whereNotIn('id', $firstSixIds)->paginate($perPage, ['*'], 'page', $page);
   
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
    
}