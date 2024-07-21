<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruang = Ruang::orderBy('id', 'DESC')->get();
        return view('admin.ruang.ruang', compact('ruang'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruang' => ['required'],
            'jam_buka' => ['required'],
            'jam_tutup' => ['required'],
        ]);

        DB::beginTransaction();

        try {
            Ruang::create($validated);
            DB::commit();
            return redirect()->back()->with('success', 'Ruang berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ruang gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ruang = Ruang::findOrFail($id);
        $now = now()->format('Y-m-d'); 

        $reservedTimes = Reservasi::where('ruang_id', $id)
            ->whereDate('tanggal', $now)
            ->where('status', 'terima')
            ->pluck('jam')
            ->flatten()
            ->toArray();
            
        return view('admin.ruang.ruang-detail', compact('ruang', 'now', 'reservedTimes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_ruang' => ['required'],
            'jam_buka' => ['required'],
            'jam_tutup' => ['required'],
        ]);

        DB::beginTransaction();

        try {
            $berita = Ruang::findOrFail($id);
            $berita->update($validated);

            DB::commit();
            return redirect()->back()->with('success', 'Ruang berhasil diubah!');
        } catch (\Throwable $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ruang gagal diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Ruang::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus.');
    }
}
