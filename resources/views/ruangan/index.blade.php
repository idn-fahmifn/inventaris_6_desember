<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Data Master Ruangan
            </h2>
            {{-- Tombol 'Tambah' --}}
            <button onclick="document.getElementById('tampilkanModal').showModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md">
                + Tambah Ruangan
            </button>
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
                                        <a href="{{ route('room.show', $item->slug) }}" class="text-sm">detail</a>
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
                    <div class="mt-4">
                        {{ $data }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create Data Ruangan --}}
    <dialog id="tampilkanModal" class="p-0 backdrop:bg-black/50 rounded-lg shadow-2xl dark:bg-gray-900">
        <div class="p-6 w-[600px]">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">
                Input Data Ruangan</h3>
            <form method="POST" action="{{ route('room.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <x-input-label for="room_name" :value="__('Nama Ruangan')" />
                        <x-text-input id="room_name" class="block mt-1 w-full" type="text" name="room_name"
                            :value="old('room_name')" required autofocus autocomplete="room_name" />
                        <x-input-error :messages="$errors->get('room_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="user_id" :value="__('Penganggung Jawab Ruangan')" />
                        <select name="user_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">-Masukan Penanggung Jawab-</option>
                            @foreach ($pic as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="room_code" :value="__('Kode Ruangan')" />
                        <x-text-input id="room_code" class="block mt-1 w-full" type="number" name="room_code"
                            :value="old('room_code')" required autofocus autocomplete="room_code" />
                        <x-input-error :messages="$errors->get('room_code')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea id="deskripsi_r" name="description"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('tampilkanModal').close()"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        Batal
                    </button>
                    <x-primary-button class="ml-3">
                        Simpan
                    </x-primary-button>
                </div>
            </form>
        </div>
    </dialog>
</x-app-layout>
