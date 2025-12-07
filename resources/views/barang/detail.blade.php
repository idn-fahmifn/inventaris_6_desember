<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    {{-- Grid utama untuk 2 kolom --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">

                        <div class="flex flex-col justify-center">
                            <div>
                                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $data->item_name }}
                                </h1>
                                <span class="text-gray-700 dark:text-gray-200">{{ $data->item_code }}</span>
                                <p class="text-md text-gray-900 dark:text-gray-400 mt-2">
                                    Penyimpanan : <span class="font-bold">{{ $data->room->room_name }}</span>
                                </p>

                                <p class="text-md text-gray-900 dark:text-gray-400 mt-2">
                                    Tanggal Pembelian : <span class="font-bold">{{ $data->date_purchase }}</span>
                                </p>

                                <p class="text-md text-gray-900 dark:text-gray-400 mt-2">
                                    Kondisi :
                                    @switch($data->status)
                                        @case('good')
                                            <span class="text-green-600 font-semibold rounded-md text-xs bg-white py-1 px-4">Baik</span>
                                        @break

                                        @case('maintenance')
                                            <span class="text-yellow-600 font-semibold rounded-md text-xs bg-white py-1 px-4">Perbaikan</span>
                                        @break

                                        @default
                                            <span class="text-red-600 font-semibold rounded-md text-xs bg-white py-1 px-4">Perbaikan</span>
                                    @endswitch
                                </p>



                                <p class="text-md text-gray-900 dark:text-gray-400 mt-2">
                                    Deskripsi : <span class="font-bold">{{ $data->description }}</span>
                                </p>

                                <form action="{{ route('item.destroy', $data->id) }}" method="post" class="py-6">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" onclick="return confirm('Yakin mau dihapus?')"
                                        class="rounded-md bg-red-500 px-2.5 py-1.5 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20">Hapus</button>
                                    <button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'show-edit')"
                                        class="rounded-md bg-yellow-500 px-2.5 py-1.5 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-white/20">Edit</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg p-4">

            </div>

        </div>
    </div>

    <x-modal name="show-edit" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('item.update', $data->id) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('put')

            <div class="space-y-4">
                <div>
                    <x-input-label for="item_name" :value="__('Nama Barang')" />
                    <x-text-input id="item_name" class="block mt-1 w-full" type="text" name="item_name"
                        value="{{$data->item_name}}" required autofocus autocomplete="item_name" />
                    <x-input-error :messages="$errors->get('item_name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="room_id" :value="__('Penyimpanan')" />
                    <select name="room_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="{{ $data->room_id }}">-{{ $data->room->room_name }}-</option>
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
                        <option value="{{ $data->status }}" class="uppercase">{{ $data->status }}</option>
                        <option value="good">Good</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="broke">Broke</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="item_code" :value="__('Kode Barang')" />
                    <x-text-input id="item_code" value="{{ $data->item_code }}" class="block mt-1 w-full" type="number" name="item_code"
                         required autofocus autocomplete="item_code" />
                    <x-input-error :messages="$errors->get('item_code')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="date_purchase" :value="__('Tanggal Pembelian')" />
                    <x-text-input id="date_purchase" class="block mt-1 w-full" type="date" name="date_purchase"
                        value="{{ $data->date_purchase }}" required autofocus autocomplete="date_purchase" />
                    <x-input-error :messages="$errors->get('date_purchase')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="image" :value="__('Gambar')" />
                    <x-text-input id="image" class="block mt-1 w-full border p-6" type="file" name="image"
                         accept="image/*" autofocus autocomplete="image" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="description" :value="__('Deskripsi')" />
                    <textarea id="deskripsi_r" name="description"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $data->description }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Keluar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Simpan') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
