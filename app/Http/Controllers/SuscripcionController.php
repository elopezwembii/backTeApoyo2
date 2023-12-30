<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suscripcion;
use Illuminate\Support\Facades\DB;

class SuscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$resp = Suscripcion::with(['persona:email', 'plan:nombre', 'cupon:codigo'])->get();
        $resp = DB::table('suscripciones as s')
                ->select('s.*', 'p.nombre', 'p.apellido', 'p.email', 'p.status', 'pl.reason', 'pl.cupon', 'pl.tipo')
                ->join('personas as p', 's.personas_id', 'p.id')
                ->join('planes as pl', 's.planes_id', 'pl.id')
                ->get();
        return response()->json($resp);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
