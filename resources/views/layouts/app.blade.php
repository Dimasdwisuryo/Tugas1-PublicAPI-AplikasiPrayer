<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/favicon.png">
    <title>@yield('title', 'Prayer Time & Quran App')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="{{ route('prayer.index') }}" class="navbar-brand">
            <span class="brand-icon">☽</span>
            PrayerTime App
        </a>
        <span class="navbar-tagline">Jadwal Sholat & Ayat Harian</span>
    </div>
</nav>

<main class="main-content">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p>Data dari <a href="https://aladhan.com" target="_blank">Aladhan API</a>
        &amp; <a href="https://alquran.cloud" target="_blank">Al-Quran Cloud API</a></p>
    </div>
</footer>

</body>
</html>
