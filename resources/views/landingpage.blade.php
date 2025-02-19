<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satria Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#4E2B24] text-[#F3D9B1]">
    <header class="flex justify-between items-center p-5">
        <div class="flex items-center space-x-2">
        <img src="/images/logo roti.png" class="h-20 w-auto">
            <span class="text-lg font-semibold">SATRIA BAKERY</span>
        </div>
        <nav class="flex space-x-6 relative top-[-8px]">
        <a href="{{ route('login') }}" class="hover:text-[#E4B97F]">Login</a>
            <a href="{{ route('register') }}" class="hover:text-[#E4B97F]">Registrasi</a>
        </nav>
    </header>

    <section class="flex flex-col md:flex-row items-center justify-center py-8 px-6 md:px-20 -mt-10">
        <div class="w-full md:w-1/2 space-y-4 relative top-[-40px]">
            <h1 class="text-5xl font-bold">WELCOME</h1>
            <h2 class="text-6xl font-bold">LINN BAKERY</h2>
            <p> Kami menyediakan berbagai jenis roti dan kue berkualitas dengan rasa terbaik. 
            Nikmati kelezatan roti yang baru dipanggang setiap hari!
        </div>
        <div class="w-full md:w-1/2">
            <img src="/images/roti molen.png" alt="Roti">
        </div>
    </section>

    <footer class="text-center py-4 text-sm">
        &copy; 2025 Linn Bakery. All Rights Reserved.
    </footer>
</body>
</html>
