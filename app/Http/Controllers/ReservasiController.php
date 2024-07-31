<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservasi = Reservasi::with('user', 'ruang')->orderBy('id', 'DESC')->get();
        return view("admin.reservasi.reservasi", compact('reservasi'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Reservasi::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }

    public function terima(string $id)
    {
        $item = Reservasi::findOrFail($id);
        $item->status = "terima";
        $item->alasan_penolakan = null;
        $item->save();

        return redirect()->back()->with('success', 'Item berhasil diterima.');
    }

    public function tolak(Request $request, string $id)
    {
        $data = $request->validate([
            'alasan_penolakan' => ['required']
        ]);

        $item = Reservasi::findOrFail($id);
        $item->status = "tolak";
        $item->alasan_penolakan = $data['alasan_penolakan'];
        $item->save();

        return redirect()->back()->with('success', 'Item berhasil ditolak.');
    }
}
