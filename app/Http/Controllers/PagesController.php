<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function ruang_detail(string $id)
    {
        $ruang = Ruang::where('id', $id)->first();
        $now = Carbon::now()->format('d/m/Y');
        return view('user.pages.ruang-detail', compact('ruang', 'now'));
    }
}
