<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Data Master Barang
            </h2>
            {{-- Tombol 'Tambah' --}}
            <button onclick="document.getElementById('tampilkanModal').showModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md">
                + Tambah Barang
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
                                    Nama Barang</th>
                                <th
                                    class="px-6 py-3 text-left text-md font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Kode Barang</th>
                                <th
                                    class="px-6 py-3 text-left text-md font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Penyimpanan</th>
                                <th
                                    class="px-6 py-3 text-left text-md font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($data as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $item->item_name }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $item->item_code }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $item->room->room_name }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        <a href="{{ route('item.show', $item->slug) }}" class="text-sm">detail</a>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="3"
                                    class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    ⚠️ Belum ada data Barang
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
                Input Data Barang</h3>
            <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <x-input-label for="item_name" :value="__('Nama Barang')" />
                        <x-text-input id="item_name" class="block mt-1 w-full" type="text" name="item_name"
                            :value="old('item_name')" required autofocus autocomplete="item_name" />
                        <x-input-error :messages="$errors->get('item_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="room_id" :value="__('Penyimpanan')" />
                        <select name="room_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">-Masukan Penanggung Jawab-</option>
                            @foreach ($room as $item)
                                <option value="{{ $item->id }}"> {{ $item->room_name }} </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="status" :value="__('Status Kondisi Barang')" />
                        <select name="status"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="good">Good</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="broke">Broke</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="item_code" :value="__('Kode Barang')" />
                        <x-text-input id="item_code" class="block mt-1 w-full" type="number" name="item_code"
                            :value="old('item_code')" required autofocus autocomplete="item_code" />
                        <x-input-error :messages="$errors->get('item_code')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="date_purchase" :value="__('Tanggal Pembelian')" />
                        <x-text-input id="date_purchase" class="block mt-1 w-full" type="date" name="date_purchase"
                            :value="old('date_purchase')" required autofocus autocomplete="date_purchase" />
                        <x-input-error :messages="$errors->get('date_purchase')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="image" :value="__('Gambar')" />
                        <x-text-input id="image" class="block mt-1 w-full border p-6" type="file" name="image"
                            :value="old('image')" accept="image/*" required autofocus autocomplete="image" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
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
