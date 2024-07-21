<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Ruang;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function ruang_detail($id, Request $request)
    {
        $selectedDate = $request->input('tanggal', now()->format('Y-m-d'));

        $ruang = Ruang::find($id);

        if (!$ruang) {
            return redirect()->back()->with('error', 'Ruang tidak ditemukan.');
        }

        $reservedTimes = [];

        if ($selectedDate) {
            $reservedTimes = Reservasi::where('ruang_id', $id)
                ->whereDate('tanggal', $selectedDate)
                ->where('status', 'terima')
                ->pluck('jam')
                ->flatten()
                ->toArray();
        }

        $ruangs = Ruang::get();

        return view('user.pages.ruang-detail', [
            'ruang' => $ruang,
            'ruangs' => $ruangs,
            'reservedTimes' => $reservedTimes,
            'selectedDate' => $selectedDate,
            'now' => $selectedDate ?: now()->format('Y-m-d')  
        ]);
    }

    public function user_profile()
    {
        return view('user.pages.profile');
    }

    public function user_reservasi()
    {
        $reservasi = Reservasi::where('user_id', auth()->user()->id)->with('ruang')->orderBy('id', 'DESC')->get();
        return view("user.pages.reservasi", compact('reservasi'));
    }
}
