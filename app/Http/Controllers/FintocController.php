<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fintoc;
use Illuminate\Support\Facades\DB;
use Http;

class FintocController extends Controller
{

    public function accounts()
    {
        $response = Http::withHeaders([
            'Authorization' => config('app.fintoc_secret_key'),
            'Accept' => 'application/json',
        ])
        ->withOptions([
            'verify' => true,
            'timeout' => 60,
            'connect_timeout' => 60,
        ])
        ->get('https://api.fintoc.com/v1/accounts', [
            'link_token' => config('app.fintoc_link_token'),
        ]);

        return $response->json();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::withHeaders([
            'Authorization' => config('app.fintoc_secret_key'),
            'Accept' => 'application/json',
        ])
        ->withOptions([
            'verify' => true,
            'timeout' => 60,
            'connect_timeout' => 60,
        ])
        ->get('https://api.fintoc.com/v1/accounts/acc_MNejK7BT7qjoGbvO/movements', [
            'link_token' => config('app.fintoc_link_token'),
        ]);

        return $response->json();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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
