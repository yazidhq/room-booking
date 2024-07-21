<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\User;
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

    public function ubah_profile(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $data = $request->all();

        $user->update($data);
        return redirect()->back()->with('success', 'Profile berhasil diupdate');
    }

    public function hapus_reservasi(string $id)
    {
        $item = Reservasi::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

    public function ajukan_ulang(string $id)
    {
        $item = Reservasi::findOrFail($id);
        $item->status = "pending";
        $item->save();

        return redirect()->back()->with('success', 'Item berhasil diterima.');
    }
}
