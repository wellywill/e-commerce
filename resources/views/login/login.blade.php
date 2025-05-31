@extends('layout.main')
@section('container')
    @if (Session()->has('authError'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Perhatian!</strong>
            <span class="block sm:inline">{{ session('authError') }}</span>
        </div>
    @endif
    <div class="flex items-center h-screen justify-center ">
        <div class="w-full max-w-sm p-8 backdrop-blur-3xl bg-coklattua rounded-2xl shadow-lg">
            @if (Session()->has('success'))
                @include('alert.registrasialert')
            @endif
            @if (Session()->has('loginError'))
                @include('alert.loginalert')
            @endif

            <h2 class="text-2xl font-bold text-center text-coklatmuda-100 drop-shadow-lg  mb-6">Login
            </h2>

            <form action="login" method="POST" class="space-y-5 ">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-white mb-1">Email</label>
                    <input type="email" id="email" name="email" autofocus required value="{{ old('email') }}"
                        class="w-full px-4 py-2 border text-white border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500" />
                </div>
                @error('email')
                    <p class="text-sm text-red-600 " id="hs-validation-name-error-helper">
                        {{ $message }}</p>
                @enderror
                <div>
                    <label for="password" class="block text-sm font-medium text-white mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border text-white border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500" />
                </div>

                <button type="submit"
                    class="w-full bg-orange-500 text-white py-2 px-4 rounded-lg hover:bg-orange-400 hover:shadow-lg hover:shadow-orange-400/50 transition duration-200">
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-400">
                Don't have an account?
                <a href="{{ route('registrasi') }}" class="text-blue-500 hover:underline">Sign up</a>
            </p>
        </div>
    </div>
@endsection
