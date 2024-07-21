@extends('user.layouts.templates')

@section('konten')
    <div class="container mt-5">
        <div class="py-5">
            <div class="row border-bottom border-dark">
                <div class="col-md-6">
                    <div class="d-flex align-items-end gap-4">
                        <h1 class="fw-bold">{{ $ruang->nama_ruang }}</h1>
                        <div class="d-flex">
                            <p class="fs-5">{{ str_pad($ruang->jam_buka, 2, '0', STR_PAD_LEFT) }}:00</p>
                            <i class="bi bi-arrow-right mx-3 fs-5"></i>
                            <p class="fs-5">{{ str_pad($ruang->jam_tutup, 2, '0', STR_PAD_LEFT) }}:00</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end mt-2">
                    <button class="btn btn-dark-blue">Reservasi Sekarang</button>
                </div>
            </div>
            <div class="mt-3 mb-2">
                <p class="fs-4 text-center fw-medium">JADWAL HARI INI - {{ $now }}</p>
            </div>
            <div class="row no-gutters">
                @for ($hour = $ruang->jam_buka; $hour < $ruang->jam_tutup; $hour++)
                    <div class="col border p-2 text-center">
                        <p class="mb-0">{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 -
                            {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00</p>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection
