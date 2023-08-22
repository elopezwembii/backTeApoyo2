<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Empresa;
use Exception;


class UserController extends Controller
{



    private function formatearRUT($rut) {
        // Eliminamos cualquier caracter que no sea número, k, K o guión
        $rutLimpio = preg_replace('/[^0-9kK\-]/', '', $rut);
    
        // Dividimos el RUT y su dígito verificador
        list($numero, $dv) = explode('-', $rutLimpio);
    
        // Removemos cualquier punto del RUT
        $numero = str_replace('.', '', $numero);
    
        // Juntamos nuevamente el número con su dígito verificador
        return $numero . '-' . $dv;
    }
    

    public function getPerfil(int $id)
    {
        $user = User::where('id', $id)->first();
        return response()->json(
            $user,
            200
        );
    }

    public function agregarUsuario(Request $request)
    {   
        //Log::info($request);

        $request->validate([
            'email' => 'string|email',
        ]);
        $user = User::create([
            'rut' => $request->rut,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'estado' => 1,
            'intentos' => 3,
            'primera_guia' => 1,
            'id_empresa' => $request->empresa == -1 ? null : $request->empresa,
        ]);

        $user->roles()->attach(1);
        return response()->json([
            'message' => 'usuario creado'
        ], 200);
    }

    public function editarPerfil(int $id, Request $request)
    {
        $request->validate([
            'fecha_nacimiento' => 'date|nullable',
            'rut' => 'string|nullable',
            'nombres' => 'string|nullable',
            'apellidos' => 'string|nullable',
            'genero' => 'string|nullable',
            'nacionalidad' => 'string|nullable',
            'ciudad' => 'string|nullable',
            'direccion' => 'string|nullable',
            'telefono' => 'string|nullable',
            'email' => 'string|nullable',
        ]);
        $user = User::where('id', $id)->first();
        $user->rut = $request->rut;
        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->genero = $request->genero;
        $user->nacionalidad = $request->nacionalidad;
        $user->ciudad = $request->ciudad;
        $user->direccion = $request->direccion;
        $user->telefono = $request->telefono;
        $user->email = $request->email;
        $user->save();


        return response()->json([
            'message' => 'usuario editado'
        ], 200);
    }

    public function obtenerUsuarios()
    {
        return response()->json(User::with(['roles', 'empresa'])->get(), 200);

    }

    public function cambiarEstado(int $id)
    {
        $user = User::where('id', $id)->first();
        $user->estado == 1 ? $user->estado = 0 : $user->estado = 1;
        $user->save();

        return response()->json([
            'message' => 'usuario editado'
        ], 200);
    }
    public function masiva(Request $request)
    {
        log::info($request);
        $errores = []; 
        
        $empresa_id = $request->input('empresa');
    
        if ($request->hasFile('archivo') && Empresa::find($empresa_id)) {
            $file = $request->file('archivo');
            log::info($request);
            
            if ($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();            
                $highestRow = $worksheet->getHighestRow();
                
                for ($row = 2; $row <= 50; $row++) {//solo procesa hasta 50 filas
                    
                    $rut = $worksheet->getCell('A' . $row)->getValue();
                    $nombre = $worksheet->getCell('B' . $row)->getValue();
                    $apellidos = $worksheet->getCell('C' . $row)->getValue();
                    $email = $worksheet->getCell('D' . $row)->getValue();
    
                    if (!$rut && !$nombre && !$apellidos && !$email) {
                        break;
                    }
    
                   // $rut = $this->formatearRUT($rut);
                 
                    try {
                        $user = User::create([
                            'rut' => $rut,
                            'nombres' => $nombre,
                            'apellidos' => $apellidos,
                            'email' => $email,
                            'password' => bcrypt($rut),
                            'estado' => 1,
                            'intentos' => 3,
                            'primera_guia' => 1,
                            'id_empresa' => 1,
                        ]);
                        $user->roles()->attach(1);
                    } catch (\Exception $e) {
                        $errorMessage = $e->getMessage();
                        
                        if (strpos($errorMessage, 'usuarios_email_unique') !== false) {
                            $errores[] = ["fila" => $row, "mensaje" => "El correo electrónico '$email' ya está registrado."];
                        } else {
                            $errores[] = ["fila" => $row, "mensaje" => "Error al procesar la fila. Por favor, verifique los datos."];
                        }
                    
                        continue;
                    }
                }
    
                if (empty($errores)) {
                    return response()->json(["success" => true, "message" => "Usuarios importados con éxito!"]);
                } else {
                    return response()->json(["success" => false, "errors" => $errores]); // 3. Devuelve el array en formato JSON.
                }
    
            } else {
                return response()->json(["success" => false, "message" => "El archivo subido no es un archivo Excel válido."]);
            }
        } else {
            return response()->json(["success" => false, "message" => "Por favor, sube un archivo."]);
        }
    }
    

    
}
