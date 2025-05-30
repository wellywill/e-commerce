<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>e-commerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        <style>html {
            scroll-behavior: smooth;
        }
    </style>

</head>

<body class="bg-cornsilk-800">
    @include('navbar.navbar')
    @yield('container')
    <script>
        const text = "SerbaDigital.ID";
        const typingSpeed = 100; // kecepatan ngetik per huruf (ms)
        const erasingSpeed = 50; // kecepatan hapus
        const delayBetween = 1500; // jeda sebelum menghapus (ms)
        let charIndex = 0;
        let isDeleting = false;

        function typeLoop() {
            const span = document.getElementById("typingText");

            if (!isDeleting) {
                span.textContent = text.substring(0, charIndex + 1);
                charIndex++;
                if (charIndex === text.length) {
                    isDeleting = true;
                    setTimeout(typeLoop, delayBetween);
                } else {
                    setTimeout(typeLoop, typingSpeed);
                }
            } else {
                span.textContent = text.substring(0, charIndex - 1);
                charIndex--;
                if (charIndex === 0) {
                    isDeleting = false;
                    setTimeout(typeLoop, 500);
                } else {
                    setTimeout(typeLoop, erasingSpeed);
                }
            }
        }

        document.addEventListener("DOMContentLoaded", typeLoop);
    </script>
</body>

</html>
