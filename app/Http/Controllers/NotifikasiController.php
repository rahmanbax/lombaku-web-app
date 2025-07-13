<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function getMyNotifications()
    {
        $notifications = Notifikasi::where('id_user', Auth::id())
            ->latest() // Urutkan dari yang terbaru
            ->take(15) // Batasi 15 notifikasi terbaru
            ->get();
        return response()->json(['success' => true, 'data' => $notifications]);
    }

    public function markAllAsRead()
    {
        Notifikasi::where('id_user', Auth::id())
            ->whereNull('dibaca_pada')
            ->update(['dibaca_pada' => now()]);
        return response()->json(['success' => true, 'message' => 'Semua notifikasi ditandai dibaca.']);
    }
}
