<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;


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
            Mail::to($request->correo)->send(new ContactMail($data));

            // El correo se envió exitosamente, puedes retornar una respuesta de éxito
            return response()->json(['message' => 'Correo enviado con éxito'], 200);
        } catch (\Exception $e) {
            // Si ocurre un error al enviar el correo, maneja el error
            return response()->json(['error' => 'Error al enviar el correo'], 500);
        }
    }
}