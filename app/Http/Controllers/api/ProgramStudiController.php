<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    /**
     * Menampilkan daftar semua program studi.
     * GET /api/program-studi
     */
    public function index()
    {
        $programStudi = ProgramStudi::orderBy('nama_program_studi')->get();
        return response()->json(['success' => true, 'data' => $programStudi], 200);
    }
}