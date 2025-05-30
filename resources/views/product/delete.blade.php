<!-- Modal Hapus Produk -->
<div id="delete-product-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
    tabindex="-1" aria-labelledby="delete-product-modal-label">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-md sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-2xs p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Yakin ingin menghapus produk ini?</h3>

            <form method="POST" id="delete-product-form">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">
                    <button type="button" class="py-2 px-4 rounded-lg border border-gray-300 hover:bg-gray-100"
                        data-hs-overlay="#delete-product-modal">
                        Batal
                    </button>
                    <button type="submit" class="py-2 px-4 rounded-lg bg-red-600 text-white hover:bg-red-700">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function setDeleteProduct(id) {
        const form = document.getElementById('delete-product-form');
        form.action = `/products/${id}`;
    }
</script>
