<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Ruang;

class PagesController extends Controller
{
    public function ruang_detail(string $id)
    {
        $ruang = Ruang::findOrFail($id);
        $now = now()->format('Y-m-d'); 

        $reservedTimes = Reservasi::where('ruang_id', $id)
            ->whereDate('tanggal', $now)
            ->where('status', 'terima')
            ->pluck('jam')
            ->flatten()
            ->toArray();
            
        return view('user.pages.ruang-detail', compact('ruang', 'now', 'reservedTimes'));
    }
}
