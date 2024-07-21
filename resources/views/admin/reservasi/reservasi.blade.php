<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reservasi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table id="ruangTable" class="display">
                        <thead>
                            <tr>
                                <th>User</th>
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
                                    <td>{{ $item->user->name }} | {{ $item->user->email }}</td>
                                    <td>{{ $item->ruang->nama_ruang }}</td>
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
                                            @if ($item->status = 'pending')
                                                <a href="{{ route('terima', $item->id) }}" class="text-blue-700 btn-sm">
                                                    Terima
                                                </a>
                                                <a href="{{ route('tolak', $item->id) }}"
                                                    class="text-blue-700 btn-sm mx-3">
                                                    Tolak
                                                </a>
                                            @endif
                                            <form action="{{ route('reservasi.destroy', $item->id) }}" method="POST"
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

</x-app-layout>
