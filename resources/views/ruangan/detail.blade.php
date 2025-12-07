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
                                    {{ $data->room_name }}
                                </h1>
                                <p class="text-md text-gray-900 dark:text-gray-400 mt-2">
                                    Penanggung Jawab : <span class="font-bold">{{ $data->user->name }}</span>
                                </p>

                                <p class="text-md text-gray-900 dark:text-gray-400 mt-2">
                                    Kode Ruangan : <span class="font-bold">{{ $data->room_code }}</span>
                                </p>
                                
                                <p class="text-md text-gray-900 dark:text-gray-400 mt-2">
                                    Deskripsi : <span class="font-bold">{{ $data->description }}</span>
                                </p>

                                <form action="{{ route('room.destroy', $data->id) }}" method="post" class="py-6">
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
        <form method="post" action="{{ route('room.edit', $data->id) }}" class="p-6">
            @csrf
            @method('put')
            <div>
                <x-input-label for="nama_ruangan" :value="__('Nama Ruangan')" />
                <x-text-input id="nama_ruangan" name="nama_ruangan" type="text" class="mt-1 block w-full"
                    :value="old('nama_ruangan', $data->nama_ruangan)" required autofocus autocomplete="nama_ruangan" />
                <x-input-error class="mt-2" :messages="$errors->get('nama_ruangan')" />
            </div>

            <div>
                <x-input-label for="user_id" :value="__('Penanggung Jawab Ruangan')" />
                <select name="user_id" required
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    id="">
                    <option value="{{ $data->id_user }}">{{ $data->user->name }}</option>
                    @foreach ($pic as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('id_user')" />
            </div>

            <div>
                <x-input-label for="ukuran" :value="__('Ukuran Ruangan')" />
                <select name="ukuran" required
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    id="">
                    <option value="{{ $data->ukuran }}">{{ $data->ukuran }}</option>
                    <option value="kecil">Kecil</option>
                    <option value="sedang">Sedang</option>
                    <option value="besar">Besar</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('ukuran')" />
            </div>

            <div>
                <x-input-label for="name" :value="__('Deskripsi Ruangan')" />
                <textarea name="deskripsi"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ $data->deskripsi }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
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
