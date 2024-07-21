<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ruangan') }}
            </h2>
            <button id="openModal" class="bg-zinc-800 text-white px-4 py-2 rounded">
                {{ __('Tambah Ruangan') }}
            </button>
        </div>
    </x-slot>

    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4">Tambah Ruangan</h2>
            <form method="POST" action="{{ route('ruang.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="nama_ruang" class="block text-gray-700">Nama Ruangan</label>
                    <input type="text" id="nama_ruang" name="nama_ruang"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="jam_buka" class="block text-gray-700">Jam Buka</label>
                    <select id="jam_buka" name="jam_buka"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @for ($hour = 0; $hour < 24; $hour++)
                            <option value="{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}">
                                {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="mb-4">
                    <label for="jam_tutup" class="block text-gray-700">Jam Tutup</label>
                    <select id="jam_tutup" name="jam_tutup"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @for ($hour = 0; $hour < 24; $hour++)
                            <option value="{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}">
                                {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="closeModal"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Tutup
                    </button>
                    <button type="submit" class="bg-zinc-800 text-white px-4 py-2 rounded ml-2">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table id="ruangTable" class="display">
                        <thead>
                            <tr>
                                <th>Nama Ruang</th>
                                <th>Jam Buka</th>
                                <th>Jam Tutup</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ruang as $item)
                                <tr>
                                    <td>{{ $item->nama_ruang }}</td>
                                    <td>{{ $item->jam_buka }}:00</td>
                                    <td>{{ $item->jam_tutup }}:00</td>
                                    <td>
                                        <div class="flex">
                                            <button type="button" class="text-blue-700 btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $item->id }}">
                                                Edit
                                            </button>

                                            <div id="editModal{{ $item->id }}"
                                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                                                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                                                    <h2 class="text-lg font-semibold mb-4">Edit Ruangan</h2>
                                                    <form method="POST"
                                                        action="{{ route('ruang.update', $item->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-4">
                                                            <label for="nama_ruang_edit"
                                                                class="block text-gray-700">Nama Ruangan</label>
                                                            <input type="text" id="nama_ruang_edit" name="nama_ruang"
                                                                value="{{ $item->nama_ruang }}"
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                                required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="jam_buka_edit" class="block text-gray-700">Jam
                                                                Buka</label>
                                                            <select id="jam_buka_edit" name="jam_buka"
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                                required>
                                                                @for ($hour = 0; $hour < 24; $hour++)
                                                                    <option
                                                                        value="{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}"
                                                                        {{ $item->jam_buka == str_pad($hour, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                                        {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="jam_tutup_edit" class="block text-gray-700">Jam
                                                                Tutup</label>
                                                            <select id="jam_tutup_edit" name="jam_tutup"
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                                required>
                                                                @for ($hour = 0; $hour < 24; $hour++)
                                                                    <option
                                                                        value="{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}"
                                                                        {{ $item->jam_tutup == str_pad($hour, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                                        {{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="flex justify-end">
                                                            <button type="button"
                                                                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
                                                                onclick="document.getElementById('editModal{{ $item->id }}').classList.add('hidden')">
                                                                Tutup
                                                            </button>
                                                            <button type="submit"
                                                                class="bg-zinc-800 text-white px-4 py-2 rounded ml-2">
                                                                Simpan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <a href="#" class="text-blue-700 btn-sm mx-3">Detail</a>
                                            <form action="{{ route('ruang.destroy', $item->id) }}" method="POST"
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openModalButton = document.getElementById('openModal');
            const modal = document.getElementById('modal');
            const closeModalButton = document.getElementById('closeModal');

            openModalButton.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });

            closeModalButton.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });

            const openEditModals = document.querySelectorAll('[data-bs-toggle="modal"]');
            openEditModals.forEach(button => {
                button.addEventListener('click', function() {
                    const targetModal = document.querySelector(this.getAttribute('data-bs-target'));
                    if (targetModal) {
                        targetModal.classList.remove('hidden');
                    }
                });
            });

            document.querySelectorAll('.close-edit-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const targetModal = document.querySelector(this.getAttribute('data-bs-target'));
                    if (targetModal) {
                        targetModal.classList.add('hidden');
                    }
                });
            });
        });
    </script>

</x-app-layout>
