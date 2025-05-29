<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" bg-gray-800">

    <div class="relative">
        <div class="absolute top-96  -z-40 right-10 bg-orange-500 w-72 h-72 rounded-full opacity-80 blur-[120px]"></div>
    </div>
    <div class="relative">
        <div
            class="absolute hidden sm:block top-80  -z-40 left-10 bg-orange-500 w-80 h-80 rounded-full opacity-80 blur-[120px]">
        </div>
    </div>
    <div class="relative">
        <div class="absolute top-28  -z-40 left-1/2 bg-orange-500 w-72 h-72  rounded-full opacity-80 blur-[120px]"></div>
    </div>


    <div class="flex items-center h-screen justify-center">
        <div class="w-full max-w-sm p-8 backdrop-blur-3xl bg-white/5 rounded-2xl shadow-lg">
            @if (Session()->has('success'))
                @include('alert.registrasialert')
            @endif
            @if (Session()->has('loginError'))
                @include('alert.loginalert')
            @endif
            <h2 class="text-2xl font-bold text-center text-orange-500 drop-shadow-lg  mb-6">Login
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
</body>

</html>
