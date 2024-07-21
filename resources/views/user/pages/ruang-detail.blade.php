@extends('user.layouts.templates')

@section('konten')
    <div class="container mt-5">
        <div class="py-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-end gap-4">
                        @if ($ruang)
                            <h1 class="fw-bold">{{ Str::upper($ruang->nama_ruang) }}</h1>
                        @else
                            <h1 class="fw-bold">Ruang Tidak Ditemukan</h1>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 text-end mt-2 d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <p class="fs-5 mb-0 fw-bold">{{ str_pad($ruang->jam_buka, 2, '0', STR_PAD_LEFT) }}:00</p>
                        <i class="bi bi-arrow-right fs-5"></i>
                        <p class="fs-5 mb-0 fw-bold">{{ str_pad($ruang->jam_tutup, 2, '0', STR_PAD_LEFT) }}:00</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="mt-4 mb-2">
                <p class="fs-4 text-center fw-medium mb-0">PILIH TANGGAL RESERVASI</p>
            </div>
            <div class="mb-4 mt-3">
                <form method="GET" action="{{ route('ruang-detail', $ruang->id ?? '') }}">
                    <div class="input-group gap-2">
                        <input type="date" class="form-control rounded-end" name="tanggal"
                            value="{{ old('tanggal', $selectedDate) }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                            required>
                        <input type="hidden" name="ruang_id" value="{{ $ruang->id ?? '' }}">
                        <button type="submit" class="btn btn-dark-blue">Pilih Tanggal</button>
                        <a href="{{ route('ruang-detail', $ruang->id) }}" class="btn btn-warning rounded-start">Reset</a>
                    </div>
                </form>
            </div>
            <div class="row no-gutters">
                @if ($ruang)
                    @for ($hour = $ruang->jam_buka; $hour < $ruang->jam_tutup; $hour++)
                        @php
                            $currentTimeSlot =
                                str_pad($hour, 2, '0', STR_PAD_LEFT) . ' - ' . str_pad($hour + 1, 2, '0', STR_PAD_LEFT);
                            $isReserved = in_array($currentTimeSlot, $reservedTimes);
                        @endphp
                        <div class="col border border-white p-2 text-center {{ $isReserved ? 'bg-danger' : 'bg-info' }}">
                            <p class="mb-0 text-white">{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 -
                                {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00</p>
                        </div>
                    @endfor
                @endif
                <button class="btn btn-dark-blue mt-4 rounded-0" data-bs-toggle="modal"
                    data-bs-target="#reservasiModal">Tentukan
                    Jam Reservasi</button>
                <div class="mt-4">
                    <i class="bi bi-square-fill text-info"></i> : Tersedia
                    <span class="mx-3"></span>
                    <i class="bi bi-square-fill text-danger"></i> : Tidak Tersedia
                </div>
            </div>
        </div>

        <hr>

        <div class="mb-5">
            <div class="mt-4 mb-2">
                <p class="fs-3 text-center fw-bold">LIHAT RUANGAN LAINNYA</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($ruangs as $item)
                    <div class="col">
                        <div class="card h-100 rounded-0 shadow border-0 card-pop">
                            <div class="card-body p-4 text-center border-top border-dark border-3">
                                <p class="card-text">
                                    <strong class="display-6 fw-bold text-dark">{{ $item->nama_ruang }}</strong>
                                </p>
                            </div>
                            <div class="d-grid px-3 pb-3">
                                <a href={{ route('ruang-detail', $item->id) }} class="btn btn-dark-blue text-white">Lihat
                                    Ruangan</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="reservasiModal" tabindex="-1" aria-labelledby="reservasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservasiModalLabel">Reservasi Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if ($selectedDate)
                    <form method="POST" action="{{ route('simpan-reservasi') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ $now }}" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="jam" class="form-label">Jam Tersedia</label>
                                <select multiple class="form-control" id="jam" name="jam[]" required>
                                    @if ($ruang)
                                        @for ($hour = $ruang->jam_buka; $hour < $ruang->jam_tutup; $hour++)
                                            @php
                                                $currentTimeSlot =
                                                    str_pad($hour, 2, '0', STR_PAD_LEFT) .
                                                    ' - ' .
                                                    str_pad($hour + 1, 2, '0', STR_PAD_LEFT);
                                                $isReserved = in_array($currentTimeSlot, $reservedTimes);
                                            @endphp
                                            <option value="{{ $currentTimeSlot }}" {{ $isReserved ? 'hidden' : '' }}>
                                                {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 -
                                                {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00
                                            </option>
                                        @endfor
                                    @endif
                                </select>
                            </div>
                            <p class="text-center">Catatan: Tekan "SHIFT" untuk memilih lebih dari 1 jam</p>
                            @if (auth()->user())
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endif
                            <input type="hidden" name="ruang_id" value="{{ $ruang->id ?? '' }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-dark-blue">Reservasi</button>
                        </div>
                    </form>
                @else
                    <p class="my-4 text-center">Silahkan pilih tanggal terlebih dahulu</p>
                @endif
            </div>
        </div>
    </div>
@endsection
