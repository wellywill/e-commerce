@extends('layout.main')
@section('container')
    <div class="min-h-screen  py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl bg-white mx-auto rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-coklattua drop-shadow-md">Kelola Kategori</h1>
                <div class="text-center my-8">
                    <div class="flex gap-2 items-center">
                        <!-- Tombol Kembali ke Dashboard -->
                        <a href="{{ route('dashboard') }}"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-100 focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Tombol Tambah Kategori -->
                        <button type="button"
                            class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-coklatmuda-100 text-white hover:bg-coklattua focus:outline-none shadow-md disabled:opacity-50 disabled:pointer-events-none"
                            aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-modal-kategori"
                            data-hs-overlay="#hs-modal-kategori">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Kategori
                        </button>
                    </div>
                </div>

            </div>
            @include('kategori.tambah')
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nama Kategori</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2">{{ $category->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $category->category_name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                                <button type="button"
                                    class="p-2 inline-flex items-center justify-center rounded-lg border border-transparent bg-cyan-600 text-white hover:bg-cyan-800 focus:outline-none"
                                    aria-haspopup="dialog" aria-expanded="false" aria-controls="edit-category-modal"
                                    data-hs-overlay="#edit-category-modal"
                                    onclick="setEditCategory({{ $category->id }}, '{{ $category->category_name }}')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </button>

                                <!-- Tombol Hapus (ikon tempat sampah) -->
                                <button type="button"
                                    class="p-2 inline-flex items-center justify-center rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-800 focus:outline-none"
                                    onclick="setDeleteCategory({{ $category->id }})"
                                    data-hs-overlay="#delete-category-modal"
                                    class="p-2 inline-flex items-center justify-center rounded-lg text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m5 0H4" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('kategori.edit')
        @include('kategori.delete')
    </div>
@endsection
