<!-- Modal -->
<div id="hs-modal-kategori" class="hs-overlay hidden fixed inset-0 z-50 overflow-y-auto" role="dialog"
    aria-labelledby="hs-modal-kategori-label" tabindex="-1">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all max-w-lg w-full mx-auto p-5">
        <div class="bg-white border border-gray-200 rounded-xl shadow-lg ">
            <div class="p-6">
                <div class="text-center mb-6">
                    <h3 id="hs-modal-kategori-label" class="text-2xl font-bold text-gray-800 ">
                        Tambah Kategori
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 ">
                        Masukkan nama kategori baru.
                    </p>
                </div>

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm mb-2 text-gray-700 ">Nama
                            Kategori</label>
                        <input type="text" name="category_name" id="category_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 "
                            placeholder="Masukkan nama kategori">
                        @error('category_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" class="py-2 px-4 rounded-lg border border-gray-300 hover:bg-gray-100 "
                            data-hs-overlay="#hs-modal-kategori">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
