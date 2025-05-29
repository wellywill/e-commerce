<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-800">
    <!-- Background Effects -->
    <div class="relative">
        <div class="absolute top-96 -z-40 right-10 bg-orange-500 w-72 h-72 rounded-full opacity-80 blur-[120px]"></div>
    </div>
    <div class="relative">
        <div
            class="absolute hidden sm:block top-80 -z-40 left-10 bg-orange-500 w-80 h-80 rounded-full opacity-80 blur-[120px]">
        </div>
    </div>
    <div class="relative">
        <div class="absolute top-28 -z-40 left-1/2 bg-orange-500 w-72 h-72 rounded-full opacity-80 blur-[120px]"></div>
    </div>

    <!-- Register Form -->
    <div class="flex items-center h-screen justify-center">
        <div class="w-full max-w-sm p-8 backdrop-blur-3xl bg-white/5 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-bold text-center text-orange-500 drop-shadow-lg mb-6">Register</h2>

            <form action="/registrasi" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="flex flex-col items-center">
                    <label for="image" class="relative cursor-pointer">
                        <div
                            class="w-28 h-28 rounded-full border-4 border-orange-500 overflow-hidden bg-gray-700 shadow-lg hover:opacity-80 transition">
                            <img id="preview" src="" alt="Preview" class="object-cover w-full h-full">
                        </div>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(event)">
                    </label>
                    <p class="mt-2 text-sm text-white">Click to upload image</p>
                </div>
                @error('image')
                    <p class="text-sm text-red-600 " id="hs-validation-name-error-helper">
                        {{ $message }}</p>
                @enderror
                <!-- Full Name -->
                <div class="">
                    <label for="name" class="block text-sm font-medium text-white mb-1">Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-2 border text-white border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500" />

                </div>
                @error('name')
                    <p class="text-sm text-red-600 " id="hs-validation-name-error-helper">
                        {{ $message }}</p>
                @enderror
                <!-- Email -->
                <div class="">
                    <label for="email" class="block text-sm font-medium text-white mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border text-white border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500" />

                </div>
                @error('email')
                    <p class="text-sm text-red-600 " id="hs-validation-name-error-helper">
                        {{ $message }}</p>
                @enderror
                <!-- Password -->
                <div class="">
                    <label for="password" class="block text-sm font-medium text-white mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border text-white border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-500" />
                </div>
                @error('password')
                    <p class="text-sm text-red-600 " id="hs-validation-name-error-helper">
                        {{ $message }}</p>
                @enderror
                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-orange-500 text-white py-2 px-4 rounded-lg hover:bg-orange-400 hover:shadow-lg hover:shadow-orange-400/50 transition duration-200">
                    Register
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login here</a>
            </p>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
