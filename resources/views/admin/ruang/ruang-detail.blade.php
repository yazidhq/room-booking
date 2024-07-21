<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($ruang->nama_ruang) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        <p class="text-2xl font-semibold text-center mb-0">
                            HARI INI ({{ $now }})</p>
                    </div>
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
                                class="border border-gray-300 p-2 text-center {{ $isReserved ? 'bg-red-500 text-white' : 'bg-blue-300 text-white' }}">
                                <p class="mb-0">{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00 -
                                    {{ str_pad($hour + 1, 2, '0', STR_PAD_LEFT) }}:00</p>
                            </div>
                        @endfor
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
