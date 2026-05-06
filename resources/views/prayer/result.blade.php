@extends('layouts.app')

@section('title', 'Jadwal Sholat ' . $city)

@section('content')

{{-- Header kota --}}
<div class="result-header">
    <a href="{{ route('prayer.index') }}" class="back-link">← Cari kota lain</a>
    <h1 class="city-title">{{ $city }}, {{ $country }}</h1>
    <div class="date-row">
        <span class="date-gregorian">{{ $date['gregorian'] }}</span>
        <span class="date-sep">·</span>
        <span class="date-hijri">{{ $date['hijri'] }}</span>
    </div>
</div>

{{-- Next prayer highlight --}}
<div class="next-prayer-banner">
    <span class="next-label">Waktu sholat berikutnya</span>
    <span class="next-name">{{ $nextPrayer['name'] }}</span>
    <span class="next-time">{{ $nextPrayer['time'] }}</span>
</div>

{{-- Jadwal sholat --}}
<div class="card">
    <h2 class="section-title">Jadwal Sholat Hari Ini</h2>

    @php
        $labels = [
            'Fajr'    => 'Subuh',
            'Dhuhr'   => 'Dzuhur',
            'Asr'     => 'Ashar',
            'Maghrib' => 'Maghrib',
            'Isha'    => 'Isya',
        ];
        $icons = [
            'Fajr'    => '🌙',
            'Dhuhr'   => '☀️',
            'Asr'     => '🌤️',
            'Maghrib' => '🌅',
            'Isha'    => '🌃',
        ];
        $now = now()->format('H:i');
    @endphp

    <div class="prayer-list">
        @foreach ($timings as $key => $time)
            @php
                $isPast = $time < $now;
                $isNext = $key === $nextPrayer['name'] || $labels[$key] === $nextPrayer['name'];
            @endphp
            <div class="prayer-row {{ $isPast ? 'past' : '' }} {{ $labels[$key] === $nextPrayer['name'] ? 'next' : '' }}">
                <div class="prayer-left">
                    <span class="prayer-icon">{{ $icons[$key] }}</span>
                    <span class="prayer-name">{{ $labels[$key] }}</span>
                </div>
                <div class="prayer-right">
                    <span class="prayer-time">{{ $time }}</span>
                    @if ($labels[$key] === $nextPrayer['name'])
                        <span class="badge-next">Berikutnya</span>
                    @elseif ($isPast)
                        <span class="badge-done">Selesai</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Ayat harian --}}
<div class="card quran-card">
    <h2 class="section-title">Ayat Harian</h2>

    @if ($ayah['success'] ?? true)
        <div class="ayah-meta">
            Surah {{ $ayah['surah'] }} ({{ $ayah['surah_id'] }}) — Ayat {{ $ayah['ayah_num'] }}
        </div>
    @endif

    <p class="ayah-arabic">{{ $ayah['arabic'] }}</p>
    <p class="ayah-translation">"{{ $ayah['indonesian'] }}"</p>

    @if (!($ayah['success'] ?? true))
        <p class="ayah-fallback-note">* Menampilkan ayat cadangan karena API tidak tersedia saat ini.</p>
    @endif
</div>

@endsection
