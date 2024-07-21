<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __($ruang->nama_ruang) }}
            </h2>
            <a href="{{ route('ruang.index') }}" id="openModal" class="bg-zinc-800 text-white px-4 py-2 rounded">
                {{ __('Kembali') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        <p class="text-2xl font-semibold text-center mb-0">DATA RESERVASI</p>
                    </div>

                    <form method="GET" action="{{ route('ruang.show', $ruang->id) }}" class="mb-4">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-2">
                            <div class="mt-4 flex items-center">
                                <i class="bi bi-square-fill text-blue-400"></i>
                                <span class="ml-2 mr-4">: Tersedia</span>
                                <i class="bi bi-square-fill text-red-500"></i>
                                <span class="ml-2">: Tidak Tersedia</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="date"
                                    class="form-input w-full md:w-auto border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    name="tanggal" value="{{ old('tanggal', $selectedDate) }}" required>
                                <button type="submit"
                                    class="bg-zinc-800 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                    Pilih Tanggal
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-4">
                        @for ($hour = $ruang->jam_buka; $hour < $ruang->jam_tutup; $hour++)
                            @php
                                $currentTimeSlot =
                                    str_pad($hour, 2, '0', STR_PAD_LEFT) .
                                    ' - ' .
                                    str_pad($hour + 1, 2, '0', STR_PAD_LEFT);
                                $isReserved = in_array($currentTimeSlot, $reservedTimes);
                            @endphp
                            <div
                                class="border border-gray-300 p-2 text-center {{ $isReserved ? 'bg-red-500 text-white' : 'bg-blue-400 text-white' }}">
                                <p class="mb-0">{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 -
                                    {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00</p>
                            </div>
                        @endfor
                    </div>

                    <div class="border p-3 mt-5">
                        <table id="ruangTable" class="display">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservasi as $item)
                                    <tr>
                                        <td>{{ $item->user->name }} | {{ $item->user->email }}</td>
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
                                                @if ($item->status = 'pending')
                                                    <a href="{{ route('terima', $item->id) }}"
                                                        class="text-blue-700 btn-sm">
                                                        Terima
                                                    </a>
                                                    <a href="{{ route('tolak', $item->id) }}"
                                                        class="text-blue-700 btn-sm mx-3">
                                                        Tolak
                                                    </a>
                                                @endif
                                                <form action="{{ route('reservasi.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Anda yakin ingin menghapus item ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-700 btn-sm">
                                                        Hapus
                                                    </button>
                                                </form>
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
</x-app-layout>
