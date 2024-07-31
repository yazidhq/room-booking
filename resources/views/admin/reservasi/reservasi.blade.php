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
                                            <span
                                                class="px-2 py-1 text-xs rounded-full text-white {{ $item->status == 'terima' ? 'bg-green-500' : 'bg-red-500' }}">
                                                Di{{ $item->status }}
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs rounded-full text-white {{ $item->status == 'pending' ? 'bg-yellow-500' : '' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex">
                                            @if ($item->status = 'pending')
                                                <a href="{{ route('terima', $item->id) }}"
                                                    class="text-blue-700 btn-sm">
                                                    Terima
                                                </a>
                                                <label for="modal-toggle-{{ $item->id }}"
                                                    class="text-blue-700 btn-sm mx-3 cursor-pointer">
                                                    Tolak
                                                </label>
                                                <input type="checkbox" id="modal-toggle-{{ $item->id }}"
                                                    class="hidden">
                                                <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden"
                                                    id="modal-{{ $item->id }}">
                                                    <div
                                                        class="bg-white rounded-lg overflow-hidden shadow-xl max-w-sm w-full">
                                                        <div class="px-6 py-4">
                                                            <div class="text-lg font-semibold text-gray-800">Alasan
                                                                Penolakan</div>
                                                            <form action="{{ route('tolak', $item->id) }}"
                                                                method="POST" class="mt-4">
                                                                @csrf
                                                                <textarea name="alasan_penolakan" class="w-full border border-gray-300 rounded p-2" rows="4"
                                                                    placeholder="Masukkan alasan penolakan"></textarea>
                                                                <div class="mt-4 flex justify-end">
                                                                    <label for="modal-toggle-{{ $item->id }}"
                                                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2 cursor-pointer">Batal</label>
                                                                    <button type="submit"
                                                                        class="bg-red-500 text-white px-4 py-2 rounded">Tolak</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <style>
                                                    #modal-toggle-{{ $item->id }}:checked+#modal-{{ $item->id }} {
                                                        display: flex;
                                                    }
                                                </style>
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
