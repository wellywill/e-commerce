 <nav class="sticky top-0 z-50">
     <div class="mx-auto  px-2 sm:px-6 lg:px-8 bg-coklattua">
         <div class="relative flex h-16 items-center justify-between">
             <div class="flex flex-1 items-center justify-start sm:items-stretch ">
                 <div class="flex items-center  space-x-3 sm:space-x-6">
                     <!-- Search input, ukuran kecil di mobile -->
                     <div class="bg-coklatmuda-100 rounded-lg">
                         <input type="text" placeholder="Cari..."
                             class="px-2 py-1 text-xs sm:px-3 sm:py-2 sm:text-sm text-white rounded-lg focus:ring-2 focus:ring-white focus:outline-none" />
                     </div>

                     <!-- Link Beranda, ukuran kecil di mobile -->
                     <a href="/"
                         class=" text-xs  sm:text-sm font-medium text-white hover:text-coklatmuda-100 hover:scale-105 hover:-translate-y-1.5 transition duration-500 ease-in-out  flex flex-col items-center "
                         aria-current="page">
                         <!-- SVG -->
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-5 sm:size-8 ">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                         </svg>
                         <span class="text-[5px] sm:text-[10px] ">Beranda</span>
                     </a>

                     <!-- Link Pesanan dengan icon -->
                     @auth
                         @can('is-customer-ui')
                             <a href="{{ route('orders.index') }}"
                                 class="text-xs sm:text-sm font-medium text-white flex flex-col items-center hover:text-coklatmuda-100 hover:scale-105 hover:-translate-y-1.5 transition duration-500 ease-in-out"
                                 aria-current="page">
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="size-5 sm:size-8">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                 </svg>
                                 <span class="text-[5px] sm:text-[10px]">Pesanan</span>
                             </a>
                         @endcan
                     @endauth

                 </div>
             </div>
             <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                 {{-- Tombol Keranjang --}}
                 <a href="{{ route('cart.index') }}"
                     class="p-1 text-white hover:text-coklatmuda-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 rounded-full group">
                     <span class="sr-only">View cart</span>
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                         <path fill-rule="evenodd"
                             d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z"
                             clip-rule="evenodd" />
                     </svg>

                     {{-- Opsional: Menampilkan jumlah item di keranjang --}}
                     @if (session('cart') && count(session('cart')) > 0)
                         <span
                             class="absolute top-5 right-20 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2 group-hover:bg-red-700">
                             {{ count(session('cart')) }}
                         </span>
                     @endif
                 </a>

                 <!-- Profile dropdown -->
                 <div x-data="{ profile: false }" class="relative ml-3">
                     <div>
                         @auth
                             <button @click="profile = !profile" type="button"
                                 class="relative flex rounded-full border border-coklatmuda-100 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                                 id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                 <span class="absolute -inset-1.5"></span>
                                 <span class="sr-only">Open user menu</span>
                                 <img class="size-8 rounded-full" src="{{ asset('storage/' . Auth::user()->image) }}"
                                     alt="User Image">
                             </button>
                         @else
                             <div class="flex gap-2">
                                 <a href="{{ route('login') }}" class="text-sm text-white hover:underline">Login</a>
                                 <a href="{{ route('registrasi') }}" class="text-sm text-white hover:underline">Register</a>
                             </div>
                         @endauth
                     </div>

                     <div x-show="profile" x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                         class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden"
                         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                         <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
                         <a href="#" class="block dur px-4 py-2 text-sm text-gray-700" role="menuitem"
                             tabindex="-1" id="user-menu-item-0">Your Profile</a>
                         <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                             id="user-menu-item-1">Settings</a>
                         @auth
                             @can('access-admin-dashboard')
                                 {{-- Gunakan nama Gate yang baru dibuat --}}
                                 <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700"
                                     role="menuitem" tabindex="-1" id="user-menu-item-1">Dashboard</a>
                             @endcan
                         @endauth
                         <form action="logout" method="POST">
                             @csrf
                             <button type="submit" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                 tabindex="-1" id="user-menu-item-2">Log Out</button>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>


 </nav>
