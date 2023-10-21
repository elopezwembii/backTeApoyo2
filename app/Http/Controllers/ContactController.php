<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

use Illuminate\Support\Facades\File;



class ContactController extends Controller
{
    public function enviarCorreoContacto(Request $request)
    {
        // Validar los datos del formulario (nombre, correo, teléfono, etc.)
        $this->validate($request, [
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'nullable|string',
            'empresa' => 'nullable|string',
            'mensaje' => 'required|string',
        ]);

        // Recopilar los datos del formulario
        $data = [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'empresa' => $request->empresa,
            'mensaje' => $request->mensaje,
        ];

        try {
            // Enviar el correo utilizando la clase de correo ContactMail
            Mail::to(env("MAIL_FROM_NAME"))->send(new ContactMail($data));

            // El correo se envió exitosamente, puedes retornar una respuesta de éxito
            return response()->json(['message' => 'Correo enviado con éxito'], 200);
        } catch (\Exception $e) {
            Log::info($e);
            // Si ocurre un error al enviar el correo, maneja el error
            return response()->json(['error' => 'Error al enviar el correo'], 500);
        }
    }


    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        Log::info('entro');
    
        $imageName = time().'.'.$request->image->extension();  
        
        // Mueve la imagen a la carpeta "uploads" dentro de "public"
        $request->image->move(public_path('uploads'), $imageName);
    
        // Devuelve la URL correcta
        return response()->json(['url' => url('uploads/'.$imageName)]);
    }
    

    public function showAll()
    {
        $directory = public_path('uploads');  // Modificamos esta línea
        $files = File::files($directory);
    
        $urls = [];
        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_BASENAME);
            $urls[] = url('uploads/' . $filename);
        }
    
        return response()->json(['urls' => $urls]);
    }

    public function deleteImage(Request $request)
{
    // Obtener la URL desde la petición
    $url = $request->get('imageurl');

    Log::info($request);
     // Reemplazar 'localhost' por '127.0.0.1:8000'
    $url = str_replace('localhost', '127.0.0.1:8000', $url);


    // Extraer el nombre del archivo de la URL
    $filename = basename($url);

    // Path completo al archivo
    $filePath = public_path('uploads/' . $filename);

    // Verificar si el archivo existe
    if (File::exists($filePath)) {
        // Eliminar el archivo
        File::delete($filePath);
        return response()->json(['message' => 'Archivo eliminado exitosamente.']);
    } else {
        return response()->json(['message' => 'Archivo no encontrado.'], 404);
    }
}
    
}