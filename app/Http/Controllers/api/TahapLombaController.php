<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TahapLomba;
use Illuminate\Http\Request;

class TahapLombaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($lombaId)
    {
        $tahapan = TahapLomba::where('id_lomba', $lombaId)->orderBy('urutan')->get();

        if ($tahapan->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada tahapan yang ditemukan untuk lomba ini.'], 404);
        }

        return response()->json(['success' => true, 'data' => $tahapan]);
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
