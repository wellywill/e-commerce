<!-- Modal Edit -->
<div id="edit-category-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
    tabindex="-1" aria-labelledby="edit-category-modal-label">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-2xs p-6 ">
            <div class="text-center mb-4">
                <h3 id="edit-category-modal-label" class="block text-2xl font-bold text-gray-800 ">
                    Edit Kategori
                </h3>
            </div>

            <form method="POST" id="edit-category-form">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="edit-category-id" />

                <div class="mb-4">
                    <label for="edit-category-name" class="block text-sm mb-2 ">Nama Kategori</label>
                    <input type="text" id="edit-category-name" name="category_name"
                        class="py-2.5 px-4 block w-full border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 "
                        required />
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" class="py-2 px-4 rounded-lg border border-gray-300 hover:bg-gray-100"
                        data-hs-overlay="#edit-category-modal">
                        Batal
                    </button>
                    <button type="submit" class="py-2 px-4 rounded-lg bg-green-600 text-white hover:bg-green-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setEditCategory(id, name) {
        document.getElementById('edit-category-id').value = id;
        document.getElementById('edit-category-name').value = name;

        const form = document.getElementById('edit-category-form');
        form.action = `/categories/${id}`; // <-- set action sesuai ID yang dipilih
    }
</script>
