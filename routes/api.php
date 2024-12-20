<?php

use App\Http\Controllers\AhorroController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\DeudaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\TarjetaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CuponController;
use App\Http\Controllers\CuponesController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\PagosController;

use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'v1'
], function () {
    Route::post('registrar', [\App\Http\Controllers\AuthController::class, 'signUp']);
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('sendEmail',[\App\Http\Controllers\AuthController::class, 'requestReset']);

    //test de personalidad financiera
    Route::post('user_test', [\App\Http\Controllers\TestController::class, 'getQuestions']);
    Route::post('submit_test', [\App\Http\Controllers\TestController::class, 'submitTest']);

    Route::middleware(['auth:api', 'rutasUsuario'])->group(function () {
        //ingresos
        Route::get('get_all_ingresos', [IngresoController::class, 'getAllIngresos']);
        Route::post('agregar_ingreso', [IngresoController::class, 'registerIngreso']);
        Route::get('ingresos_fijos', [IngresoController::class, 'getIngresoFijo']);
        Route::get('ingresos_variables', [IngresoController::class, 'getIngresoVariable']);
        Route::get('total_fijo', [IngresoController::class, 'getTotalFijoMes']);
        Route::get('total_variable', [IngresoController::class, 'getTotalVariableMes']);
        Route::post('ingreso/{id}', [IngresoController::class, 'editIngreso']);
        Route::delete('ingreso/{id}', [IngresoController::class, 'deleteIngreso']);
        Route::get('validaSiTieneIngreso', [IngresoController::class, 'validarSiTieneIngreso']);

        //gastos
        Route::post('agregar_gasto', [GastoController::class, 'registerGasto']);

        Route::post('agregar_gasto_asociandoAhorro', [GastoController::class, 'registerGastoAsociandoAhorro']);
        Route::post('agregar_gasto_asociandoDeuda', [GastoController::class, 'registerGastoAsociandoDeuda']);

        Route::get('gastos_fijos', [GastoController::class, 'getGastoFijo']);
        Route::get('gastos_variables', [GastoController::class, 'getGastoVariable']);
        Route::post('gasto/{id}', [GastoController::class, 'editGasto']);
        Route::delete('gasto/{id}', [GastoController::class, 'deleteGasto']);

        //presupuesto
        Route::get('presupuesto_por_mes', [PresupuestoController::class, 'createOrReturnPresupuesto']);
        Route::post('agregar_item_presupuesto', [PresupuestoController::class, 'agregarItem']);
        Route::post('mantener_presupuesto_mes_anterior', [PresupuestoController::class, 'replicaPresupuesto']);
        Route::delete('item_presupuesto/{id}', [PresupuestoController::class, 'eliminarItem']);
        Route::get('validaSiTienePresupuesto', [PresupuestoController::class, 'validarSiTienePresupuesto']);

        //deuda
        Route::post('agregar_deuda', [DeudaController::class, 'registrarDeuda']);
        Route::get('obtener_deuda', [DeudaController::class, 'obtenerDeudas']);
        Route::delete('deuda/{id}', [DeudaController::class, 'eliminarDeuda']);
        Route::post('deuda/{id}', [DeudaController::class, 'editarDeuda']);

        //tarjeta
        Route::post('agregar_tarjeta', [TarjetaController::class, 'registrarTarjeta']);
        Route::get('obtener_tarjetas', [TarjetaController::class, 'obtenerTarjetas']);
        Route::delete('tarjeta/{id}', [TarjetaController::class, 'eliminarTarjeta']);
        Route::post('tarjeta/{id}', [TarjetaController::class, 'editarTarjeta']);

        //ahorro
        Route::post('agregar_ahorro', [AhorroController::class, 'registrarAhorro']);
        Route::get('obtener_ahorro', [AhorroController::class, 'obtenerAhorros']);
        Route::delete('ahorro/{id}', [AhorroController::class, 'eliminarAhorro']);
        Route::post('ahorro/{id}', [AhorroController::class, 'editarAhorro']);

       Route::put('ahorro/{id}/actualizar-monto', [AhorroController::class, 'actualizarMonto']);


        //bien
        Route::post('agregar_bien', [BienController::class, 'registrarBien']);
        Route::get('obtener_bien', [BienController::class, 'obtenerBienes']);
        Route::delete('bien/{id}', [BienController::class, 'eliminarBien']);
        Route::post('bien/{id}', [BienController::class, 'editarBien']);

        //perfil
        Route::get('perfil/{id}', [UserController::class, 'getPerfil']);
        Route::post('perfil/{id}', [UserController::class, 'editarPerfil']);

        //usuario
        Route::get('usuarios', [UserController::class, 'obtenerUsuarios']);
        Route::post('usuarios', [UserController::class, 'agregarUsuario']);
        Route::get('usuarios/cambiar-perfil/{id}', [UserController::class, 'cambiarEstado']);
        Route::post('masiva', [UserController::class, 'masiva']);
        Route::get('nivel', [UserController::class, 'getNivel']);

        //empresa
        Route::get('empresa', [EmpresaController::class, 'getEmpresas']);
        Route::post('empresa', [EmpresaController::class, 'crearEmpresaYEncargado']);
        Route::get('empresa/{id}', [EmpresaController::class, 'getCantidadColaboradores']);

        //promo cupones
        Route::post('promo_cupones', [CuponController::class, 'store']);
        Route::get('cupones', [CuponController::class, 'index']);
        Route::post('edit_cupones', [CuponController::class, 'update']);

        //planes
        Route::get('planes', [PlanController::class, 'index']);
        Route::post('crearPlanes', [PlanController::class, 'crearPlanes']);
        Route::get('searchplan/{go}', [PlanController::class, 'search']);
        Route::get('sincronizar/{go}', [PlanController::class, 'sincronizar']);
        Route::post('eliminar_plan', [PlanController::class, 'destroy']);
        Route::post('promo_front', [PlanController::class, 'promoUp']);

        //Route::post('addplan', [PlanController::class, 'store']);
        Route::post('updateplan', [PlanController::class, 'update']);

        //suscriptores
        Route::get('suscriptores', [SuscripcionController::class, 'index']);

    });

    Route::get('/user', function (Request $request) {
        return Auth::user();
    })->middleware(['auth:api', 'rutasUsuario']);
});

//api pagina web
/*
Route::group(['prefix' => 'v1/web'], function () {
    Route::middleware(['api-token'])->group(function () {
        Route::post('usar_cupon', [CuponController::class, 'usarCupon']);
    });
});*/


//blogs
Route::get('v1/getFirstSixBlogs/{id}', [BlogsController::class, 'getFirstSixBlogs']);
Route::get('v1/blogs/{id}', [BlogsController::class, 'getBlogs']);

Route::delete('v1/blogs/{id}', [BlogsController::class, 'destroy']);

Route::post('v1/addBlogs', [BlogsController::class, 'crearBlogs']);
Route::get('v1/categorias', [BlogsController::class, 'getCategorias']);
Route::get('v1/search', [BlogsController::class, 'searchBlogs']);
Route::get('v1/detalleBlogs/{id}', [BlogsController::class, 'show']);
Route::put('v1/blogs/{id}/update-description', [BlogsController::class, 'updateDescription']);


Route::get('v1/plan_all', [PlanController::class, 'planesFron']);
Route::post('v1/usar_cupon', [CuponController::class, 'usarCupon']);
Route::post('v1/registrarUs', [CuponController::class, 'registrar']);
Route::post('v1/contacto', [ContactController::class, 'enviarCorreoContacto']);
Route::post('v1/process_payment', [PagosController::class, 'process']);

Route::post('v1/upload', [ContactController::class, 'upload']);
Route::get('v1/showAll', [ContactController::class, 'showAll']);
Route::post('v1/deleteImage', [ContactController::class, 'deleteImage']);


