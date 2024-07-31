{{-- @extends('user.layouts.templates')

@section('konten')
    @include('user.layouts.jumbroton')

    <div class="container">

        <section class="mb-5">
            <p class="fs-1 fw-bold text-dark text-center py-3">Ruang</p>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($ruang as $item)
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
        </section>

    </div>
@endsection --}}

@extends('user.layouts.templates')

@section('konten')
    @include('user.layouts.jumbroton')

    <div class="container mt-5">
        <div class="py-5">
            <div class="mt-4 mb-2">
                <p class="fs-2 fw-bold text-center fw-medium mb-5">PILIH TANGGAL RESERVASI</p>
            </div>
            <div class="mb-5 mt-3">
                <form method="GET" action="{{ route('home') }}">
                    <div class="input-group gap-2">
                        <input type="date" class="form-control rounded-end" name="tanggal"
                            value="{{ old('tanggal', $selectedDate) }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                            required>
                        <button type="submit" class="btn btn-dark-blue">Pilih Tanggal</button>
                        <a href="{{ route('home') }}" class="btn btn-warning rounded-start">Reset</a>
                    </div>
                </form>
            </div>

            @foreach ($ruangDetails as $detail)
                @php
                    $ruang = $detail['ruang'];
                    $reservedTimes = $detail['reservedTimes'];
                    $selectedDate = $detail['selectedDate'];
                    $now = $detail['now'];
                @endphp
                <div class="bg-light shadow rounded">
                    <div class="mb-5 p-5 border-top border-info border-5 rounded">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="fw-bold">{{ $ruang->nama_ruang }}</h2>
                            <div class="d-flex align-items-center gap-3">
                                <p class="fs-5 mb-0 fw-bold">{{ str_pad($ruang->jam_buka, 2, '0', STR_PAD_LEFT) }}:00</p>
                                <i class="bi bi-arrow-right fs-5"></i>
                                <p class="fs-5 mb-0 fw-bold">{{ str_pad($ruang->jam_tutup, 2, '0', STR_PAD_LEFT) }}:00</p>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            @for ($hour = $ruang->jam_buka; $hour < $ruang->jam_tutup; $hour++)
                                @php
                                    $currentTimeSlot =
                                        str_pad($hour, 2, '0', STR_PAD_LEFT) .
                                        ' - ' .
                                        str_pad($hour + 1, 2, '0', STR_PAD_LEFT);
                                    $isReserved = in_array($currentTimeSlot, $reservedTimes);
                                @endphp
                                <div
                                    class="col border border-light p-2 text-center {{ $isReserved ? 'bg-danger' : 'bg-info' }}">
                                    <p class="mb-0 text-white">{{ $currentTimeSlot }}</p>
                                </div>
                            @endfor
                        </div>
                        <div class="text-center">
                            <button class="btn btn-dark-blue mt-4" data-bs-toggle="modal"
                                data-bs-target="#reservasiModal-{{ $ruang->id }}">Tentukan Jam Reservasi</button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="reservasiModal-{{ $ruang->id }}" tabindex="-1"
                    aria-labelledby="reservasiModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reservasiModalLabel">Reservasi Ruangan -
                                    {{ $ruang->nama_ruang }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ route('simpan-reservasi') }}">
                                @csrf
                                <div class="modal-body">
                                    @if (auth()->user())
                                        <input hidden type="text" name="user_id" value="{{ auth()->user()->id }}">
                                    @endif

                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            value="{{ $now }}" required readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jam" class="form-label">Jam Tersedia</label>
                                        <select multiple class="form-control" id="jam" name="jam[]" required>
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
                                        </select>
                                    </div>
                                    <p class="text-center">Catatan: Tekan "SHIFT" untuk memilih lebih dari 1 jam</p>
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
            @endforeach
        </div>
    </div>
@endsection
