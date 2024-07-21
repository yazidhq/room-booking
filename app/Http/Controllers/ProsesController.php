<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    public function simpan_reservasi(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'ruang_id' => 'required',
            'tanggal' => 'required',
            'jam' => 'required|array', 
        ]);

        Reservasi::create($validated);

        return redirect()->back()->with('success', 'Reservasi berhasil dibuat.');
    }
}
