<!-- Modal Tambah Produk -->
<div id="create-product-modal" class="hs-overlay hidden fixed inset-0 z-50 overflow-y-auto" role="dialog"
    aria-labelledby="create-product-modal-label" tabindex="-1">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all max-w-lg w-full mx-auto p-5">
        <div class="bg-white border border-gray-200 rounded-xl shadow-lg">
            <div class="p-6">
                <div class="text-center mb-6">
                    <h3 id="create-product-modal-label" class="text-2xl font-bold text-gray-800">
                        Tambah Produk
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Masukkan data produk baru.
                    </p>
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="product_name" class="block text-sm mb-2 text-gray-700">Nama Produk</label>
                        <input type="text" name="product_name" id="product_name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan nama produk" value="{{ old('product_name') }}">
                        @error('product_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image_product" class="block text-sm mb-2 text-gray-700">Gambar Produk (Satu)</label>
                        <input type="file" name="image_product" id="image_product" onchange="previewImage()"
                            accept="image/*"
                            class="w-full text-sm text-gray-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-blue-50 file:text-blue-700
                                   hover:file:bg-blue-100" />
                        <img src="" class="tambah_image_preview hidden w-20 mt-2 rounded" alt="Preview">
                        @error('image_product')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="gallery_product" class="block text-sm mb-2 text-gray-700">Galeri Produk (Banyak
                            Gambar)</label>
                        <input type="file" name="gallery_product[]" id="gallery_product" onchange="previewGallery()"
                            accept="image/*" multiple
                            class="w-full text-sm text-gray-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-blue-50 file:text-blue-700
                                   hover:file:bg-blue-100" />
                        <div id="gallery_preview_container" class="flex flex-wrap gap-2 mt-2"></div>

                        @error('gallery_product')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm mb-2 text-gray-700">Harga</label>
                        <input type="number" name="price" id="price" required min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan harga produk" value="{{ old('price') }}">
                        @error('price')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="qty" class="block text-sm mb-2 text-gray-700">Jumlah (Qty)</label>
                        <input type="number" name="qty" id="qty" required min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan jumlah produk" value="{{ old('qty') }}">
                        @error('qty')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm mb-2 text-gray-700">Deskripsi</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan deskripsi produk">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm mb-2 text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" disabled selected>Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" class="py-2 px-4 rounded-lg border border-gray-300 hover:bg-gray-100"
                            data-hs-overlay="#create-product-modal">
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
<script>
    function previewImage() {
        const image = document.querySelector('#image_product');
        const imgPreview = document.querySelector('.tambah_image_preview');

        if (!image.files || !image.files[0]) return;

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    function previewGallery() {
        const image = document.querySelector('#gallery_product');
        const container = document.querySelector('#gallery_preview_container'); // ganti sesuai ID

        container.innerHTML = ''; // kosongkan preview sebelumnya

        if (!image.files || image.files.length === 0) return;

        Array.from(image.files).forEach(file => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-20', 'mt-2', 'rounded', 'object-cover');
                container.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    }
</script>
