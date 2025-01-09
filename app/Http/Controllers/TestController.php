<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Preuser;
use App\Models\UserTest;
use App\Models\PersonalidadTipo;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestUserEmail;

class TestController extends Controller
{
    public function getQuestions(Request $request)
    {
        $preuser = Preuser::firstOrCreate([
            'email' => $request->email,
            'autoriza' => $request->autoriza
        ]);
        $user = Preuser::where('email', $request->email)->first();

        $preguntas = Pregunta::with('respuestas')->inRandomOrder()->limit(7)->get();
        return response()->json(["preguntas" => $preguntas, "user" => $user->id]);
    }

    public function enviarCorreoTest($email, $personalidad)
    {
        $data = [
            'email' => $email,
            'personalidad' => $personalidad
        ];
        try {
            Mail::to(env("MAIL_FROM_NAME"))->send(new TestUserEmail($data));
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            return false;
        }
    }

    public function submitTest(Request $request)
    {
        $respuestas = $request->all();
        $user = null;

        foreach ($respuestas as $id => $value) {
            $userTest = UserTest::create([
                'preusers_id' => $value['preusers_id'],
                'pregunta_id' => $value['pregunta_id'],
                'respuesta_id' => $value['respuesta_id'],
            ]);
            $user = $userTest->preusers_id;
        }

        $userTests = UserTest::with('respuesta.personalidadTipo')
            ->where('preusers_id', $user)
            ->get();

        $personalidadCount = [];

        foreach ($userTests as $userTest) {
            $personalidadTipoId = $userTest->respuesta->personalidad_tipo_id;
            if (isset($personalidadCount[$personalidadTipoId])) {
                $personalidadCount[$personalidadTipoId]++;
            } else {
                $personalidadCount[$personalidadTipoId] = 1;
            }
        }

        if (empty($personalidadCount)) {
            return response()->json([
                'error' => 'No se pudieron determinar los datos de personalidad.',
            ], 400);
        }

        $maxCount = max($personalidadCount);
        $personalidadTipoId = array_search($maxCount, $personalidadCount);

        $personalidad = PersonalidadTipo::find($personalidadTipoId);

        if (!$personalidad) {
            return response()->json([
                'error' => 'No se encontró información de personalidad.',
            ], 400);
        }

        $userPre = Preuser::find($user);
        if ($userPre) {
            $this->enviarCorreoTest($userPre->email, $personalidad->descripcion);
        }

        return response()->json([
            'personalidad' => $personalidad->descripcion,
            'definicion' => $personalidad->definicion,
        ]);
    }

}
