<!-- Toast -->
<div id="dismiss-alert"
    class=" hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300 max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg"
    role="alert">
    <div class="flex p-4">
        <div class="flex-shrink-0">
            <svg class="size-5 text-gray-600 mt-1 " xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
            </svg>
        </div>
        <div class="ms-4">
            <h3 class="text-gray-800 font-semibold ">
                App notifications
            </h3>
            <div class="mt-1 text-sm text-gray-600 ">
                {{ Session('success') }}
            </div>
            <div class="mt-4 ">
                <div class="flex space-x-3">
                    <button type="button"
                        class="text-slate-600 decoration-2 hover:underline font-medium text-sm focus:outline-none focus:underline "
                        data-hs-remove-element="#dismiss-alert">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- End Toast -->
