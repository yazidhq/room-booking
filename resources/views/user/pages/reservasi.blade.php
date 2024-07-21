@extends('user.layouts.templates')

@section('konten')
    <div class="bg-light" style="padding-bottom:15vh">
        <div class="container mt-5">
            <div class="py-5">
                <div class="bg-white p-5 shadow-sm rounded">
                    <div class="row">
                        <div class="col-md-2 border-2">
                            <a href="{{ route('user-profile') }}" class="text-decoration-none">
                                <p class="{{ request()->routeIs('user-profile') ? 'fw-bold text-dark-blue' : 'text-dark' }}">
                                    Profile
                                </p>
                            </a>
                            <a href="{{ route('user-reservasi') }}" class="text-decoration-none">
                                <p
                                    class="{{ request()->routeIs('user-reservasi') ? 'fw-bold text-dark-blue' : 'text-dark' }}">
                                    Reservasi
                                </p>
                            </a>
                        </div>
                        <div class="col-md-10 px-5 border-start border-2">
                            <p class="fs-3 fw-bold">Reservasi</p>

                            <div class="border p-3">
                                <table id="ruangTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>Ruang</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservasi as $item)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('ruang-detail', $item->ruang->id) }}"
                                                        class="text-decoration-none fw-medium text-dark-blue">
                                                        {{ $item->ruang->nama_ruang }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->tanggal }}</td>
                                                <td>
                                                    @foreach ($item->jam as $key => $jam)
                                                        {{ $jam }}{{ $key < count($item->jam) - 1 ? ' | ' : '' }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if ($item->status == 'terima' || $item->status == 'tolak')
                                                        Di{{ $item->status }}
                                                    @else
                                                        {{ ucfirst($item->status) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="flex">
                                                        @if ($item->status == 'pending')
                                                            <form action="{{ route('hapus-reservasi', $item->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Anda yakin ingin menghapus item ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="d-grid">
                                                                    <button type="submit"
                                                                        class="btn btn-warning btn-sm text-white">
                                                                        Batal
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        @elseif($item->status == 'tolak')
                                                            <div class="d-grid">
                                                                <a href="{{ route('ajukan-ulang', $item->id) }}"
                                                                    type="submit" class="btn btn-info btn-sm text-white">
                                                                    Ajukan Ulang
                                                                </a>
                                                            </div>
                                                        @elseif($item->status == 'terima')
                                                            <div class="d-grid">
                                                                <button type="submit" class="btn btn-success btn-sm"
                                                                    disabled>
                                                                    Diterima
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
