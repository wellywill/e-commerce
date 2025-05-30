<!-- Modal Edit Produk -->
<div id="edit-product-modal" class="hs-overlay hidden fixed inset-0 z-50 overflow-y-auto" role="dialog"
    aria-labelledby="edit-product-modal-label" tabindex="-1">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all max-w-xl w-full mx-auto p-5">
        <div class="bg-white border border-gray-200 rounded-xl shadow-lg">
            <div class="p-6">
                <div class="text-center mb-6">
                    <h3 id="edit-product-modal-label" class="text-2xl font-bold text-gray-800">
                        Edit Produk
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Ubah informasi produk sesuai kebutuhan.
                    </p>
                </div>

                <form id="edit-product-form" action="{{ route('products.update', ':id') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_product_id">

                    <div class="mb-4">
                        <label for="edit_product_name" class="block text-sm mb-2 text-gray-700">Nama Produk</label>
                        <input type="text" name="product_name" id="edit_product_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_image_product" class="block text-sm mb-2 text-gray-700">Gambar Produk</label>
                        <input type="file" name="image_product" id="edit_image_product"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <img id="edit_preview_image" src="" class="w-20 mt-2 rounded" alt="Preview">
                    </div>
                    <div class="mb-4">
                        <label for="edit_gallery_product" class="block text-sm mb-2 text-gray-700">Gallery Produk (bisa
                            pilih lebih dari satu)</label>
                        <input type="file" name="gallery_product[]" id="edit_gallery_product" multiple
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <div id="edit_gallery_combined_preview" class="mt-2 flex gap-2 flex-wrap">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="edit_price" class="block text-sm mb-2 text-gray-700">Harga</label>
                        <input type="number" name="price" id="edit_price"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_qty" class="block text-sm mb-2 text-gray-700">Qty</label>
                        <input type="number" name="qty" id="edit_qty"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_category_id" class="block text-sm mb-2 text-gray-700">Kategori</label>
                        <select name="category_id" id="edit_category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="edit_description" class="block text-sm mb-2 text-gray-700">Deskripsi</label>
                        <textarea name="description" id="edit_description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" class="py-2 px-4 rounded-lg border border-gray-300 hover:bg-gray-100"
                            data-hs-overlay="#edit-product-modal">Batal</button>
                        <button type="submit" class="py-2 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function openEditModal(product) {
        const form = document.getElementById('edit-product-form');
        form.action = `/products/${product.id}`;
        document.getElementById('edit_product_id').value = product.id;
        document.getElementById('edit_product_name').value = product.product_name;
        document.getElementById('edit_price').value = product.price;
        document.getElementById('edit_qty').value = product.qty;
        document.getElementById('edit_description').value = product.description ?? '';
        document.getElementById('edit_category_id').value = product.category_id;

        // Preview gambar utama
        const previewImageProduct = document.getElementById('edit_preview_image');
        previewImageProduct.src = product.image_product ? `/storage/${product.image_product}` : '';
        previewImageProduct.style.display = product.image_product ? 'block' :
            'none'; // Sembunyikan jika tidak ada gambar


        // Preview galeri gambar lama
        const galleryCombinedPreview = document.getElementById('edit_gallery_combined_preview');
        galleryCombinedPreview.innerHTML = ''; // Kosongkan dulu biar tidak numpuk

        let galleryProducts = [];
        if (product.gallery_product) {
            try {
                // Coba parse jika formatnya string JSON
                galleryProducts = JSON.parse(product.gallery_product);
            } catch (e) {
                // array atau string 
                if (Array.isArray(product.gallery_product)) {
                    galleryProducts = product.gallery_product;
                } else if (typeof product.gallery_product === 'string') {
                    // Jika string biasa 
                    galleryProducts = product.gallery_product.split(',').map(item => item.trim()).filter(item =>
                        item !== '');
                }
            }
        }

        if (galleryProducts.length > 0) {
            galleryProducts.forEach(filename => {
                const img = document.createElement('img');
                img.src = `/storage/${filename}`; // 
                img.alt = 'Gallery image';
                img.className = 'w-20 h-20 object-cover rounded';
                galleryCombinedPreview.appendChild(img);
            });
        }
        window.HSOverlay.open(document.querySelector('#edit-product-modal'));
    }
</script>
<script>
    // Event listener untuk preview gambar produk utama yang baru dipilih
    document.getElementById('edit_image_product').addEventListener('change', function(e) {
        const preview = document.getElementById('edit_preview_image');
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
    // Event listener untuk preview galeri produk baru
    document.getElementById('edit_gallery_product').addEventListener('change', function(e) {
        const galleryCombinedPreview = document.getElementById('edit_gallery_combined_preview');

        galleryCombinedPreview.innerHTML = '';

        if (e.target.files && e.target.files.length > 0) {
            Array.from(e.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.classList.add('w-20', 'h-20', 'object-cover', 'rounded');
                    galleryCombinedPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

    });
</script>
