<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Data Master Ruangan
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 min-h-[400px]">

                <div class="overflow-x-auto">
                    {{-- Tabel untuk menampilkan data ruangan (kosong) --}}
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-md font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Ruangan</th>
                                <th
                                    class="px-6 py-3 text-left text-md font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Kode Ruangan</th>
                                <th
                                    class="px-6 py-3 text-left text-md font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Penanggung Jawab</th>
                                <th
                                    class="px-6 py-3 text-left text-md font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($data as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $item->room_name }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $item->room_code }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $item->user->name }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        <a href="{{ route('petugas.show.room', $item->slug) }}" class="text-sm">detail</a>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="3"
                                    class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    ⚠️ Belum ada data ruangan
                                </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
