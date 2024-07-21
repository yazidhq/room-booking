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
                    <button class="btn btn-dark-blue" data-bs-toggle="modal" data-bs-target="#reservasiModal">Reservasi
                        Sekarang</button>
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

    <div class="modal fade" id="reservasiModal" tabindex="-1" aria-labelledby="reservasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservasiModalLabel">Reservasi Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('simpan-reservasi') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="jam" class="form-label">Jam</label>
                            <select multiple class="form-control" id="jam" name="jam[]" required>
                                @for ($hour = $ruang->jam_buka; $hour < $ruang->jam_tutup; $hour++)
                                    <option
                                        value="{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }} - {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}">
                                        {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 -
                                        {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <p>Note: Tekan "SHIFT" untuk memilih lebih dari 1 jam</p>
                        @if (auth()->user())
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endif
                        <input type="hidden" name="ruang_id" value="{{ $ruang->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-dark-blue">Reservasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
