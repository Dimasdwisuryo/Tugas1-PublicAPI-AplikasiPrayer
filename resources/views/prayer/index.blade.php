@extends('layouts.app')

@section('title', 'Prayer Time & Quran App')

@section('content')

<div class="hero">
    <h1 class="hero-title">Jadwal Sholat & Ayat Harian</h1>
    <p class="hero-subtitle">Masukkan nama kota untuk melihat jadwal sholat hari ini</p>
</div>

<div class="card search-card">
    <form action="{{ route('prayer.show') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="country" class="form-label">Pilih Negara</label>
            <select name="country" id="country" class="form-input" onchange="updateCityPlaceholder(this)">
                <option value="">-- Pilih Negara --</option>
                <optgroup label="Asia Tenggara">
                    <option value="ID">🇮🇩 Indonesia</option>
                    <option value="MY">🇲🇾 Malaysia</option>
                    <option value="SG">🇸🇬 Singapura</option>
                    <option value="BN">🇧🇳 Brunei Darussalam</option>
                    <option value="PH">🇵🇭 Filipina</option>
                    <option value="TH">🇹🇭 Thailand</option>
                </optgroup>
                <optgroup label="Asia Selatan">
                    <option value="PK">🇵🇰 Pakistan</option>
                    <option value="BD">🇧🇩 Bangladesh</option>
                    <option value="IN">🇮🇳 India</option>
                    <option value="AF">🇦🇫 Afghanistan</option>
                    <option value="MV">🇲🇻 Maladewa</option>
                </optgroup>
                <optgroup label="Timur Tengah">
                    <option value="SA">🇸🇦 Arab Saudi</option>
                    <option value="AE">🇦🇪 Uni Emirat Arab</option>
                    <option value="TR">🇹🇷 Turki</option>
                    <option value="EG">🇪🇬 Mesir</option>
                    <option value="IQ">🇮🇶 Irak</option>
                    <option value="IR">🇮🇷 Iran</option>
                    <option value="JO">🇯🇴 Yordania</option>
                    <option value="KW">🇰🇼 Kuwait</option>
                    <option value="LB">🇱🇧 Lebanon</option>
                    <option value="OM">🇴🇲 Oman</option>
                    <option value="QA">🇶🇦 Qatar</option>
                    <option value="YE">🇾🇪 Yaman</option>
                    <option value="SY">🇸🇾 Suriah</option>
                    <option value="PS">🇵🇸 Palestina</option>
                </optgroup>
                <optgroup label="Afrika">
                    <option value="MA">🇲🇦 Maroko</option>
                    <option value="DZ">🇩🇿 Aljazair</option>
                    <option value="TN">🇹🇳 Tunisia</option>
                    <option value="LY">🇱🇾 Libya</option>
                    <option value="SD">🇸🇩 Sudan</option>
                    <option value="SO">🇸🇴 Somalia</option>
                    <option value="NG">🇳🇬 Nigeria</option>
                    <option value="SN">🇸🇳 Senegal</option>
                    <option value="ET">🇪🇹 Ethiopia</option>
                </optgroup>
                <optgroup label="Asia Tengah">
                    <option value="UZ">🇺🇿 Uzbekistan</option>
                    <option value="KZ">🇰🇿 Kazakhstan</option>
                    <option value="TM">🇹🇲 Turkmenistan</option>
                    <option value="TJ">🇹🇯 Tajikistan</option>
                    <option value="KG">🇰🇬 Kirgizstan</option>
                    <option value="AZ">🇦🇿 Azerbaijan</option>
                </optgroup>
                <optgroup label="Eropa">
                    <option value="AL">🇦🇱 Albania</option>
                    <option value="BA">🇧🇦 Bosnia Herzegovina</option>
                    <option value="XK">🇽🇰 Kosovo</option>
                    <option value="GB">🇬🇧 Inggris</option>
                    <option value="DE">🇩🇪 Jerman</option>
                    <option value="FR">🇫🇷 Prancis</option>
                    <option value="NL">🇳🇱 Belanda</option>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label for="city" class="form-label">Nama Kota</label>
            <input
                type="text"
                name="city"
                id="city"
                class="form-input @error('city') input-error @enderror"
                placeholder="Ketik nama kota..."
                value="{{ old('city') }}"
                autofocus
            >
            @error('city')
                <p class="error-msg">{{ $message }}</p>
            @enderror
            <p class="city-hint" id="city-hint">Pilih negara dulu untuk melihat contoh kota</p>
        </div>

        <button type="submit" class="btn-primary">
            Cari Jadwal Sholat →
        </button>
    </form>
</div>

<div class="info-grid">
    <div class="info-card">
        <div class="info-icon">🕌</div>
        <h3>5 Waktu Sholat</h3>
        <p>Subuh, Dzuhur, Ashar, Maghrib, Isya — akurat berdasarkan lokasi</p>
    </div>
    <div class="info-card">
        <div class="info-icon">📖</div>
        <h3>Ayat Harian</h3>
        <p>Ayat Al-Quran yang berganti setiap hari, lengkap dengan terjemahan</p>
    </div>
    <div class="info-card">
        <div class="info-icon">📅</div>
        <h3>Tanggal Hijriyah</h3>
        <p>Kalender Hijriyah ditampilkan bersama jadwal sholat</p>
    </div>
</div>

<script>
const cityExamples = {
    ID: 'contoh: Surabaya, Jakarta, Sidoarjo, Bandung',
    MY: 'contoh: Kuala Lumpur, Johor Bahru, Penang',
    SG: 'contoh: Singapore',
    BN: 'contoh: Bandar Seri Begawan',
    PH: 'contoh: Manila, Davao, Zamboanga',
    TH: 'contoh: Bangkok, Pattani, Narathiwat',
    PK: 'contoh: Karachi, Lahore, Islamabad',
    BD: 'contoh: Dhaka, Chittagong, Sylhet',
    IN: 'contoh: Mumbai, Delhi, Hyderabad',
    AF: 'contoh: Kabul, Kandahar, Herat',
    MV: 'contoh: Male',
    SA: 'contoh: Makkah, Madinah, Riyadh, Jeddah',
    AE: 'contoh: Dubai, Abu Dhabi, Sharjah',
    TR: 'contoh: Istanbul, Ankara, Izmir',
    EG: 'contoh: Cairo, Alexandria, Giza',
    IQ: 'contoh: Baghdad, Basra, Mosul',
    IR: 'contoh: Tehran, Isfahan, Mashhad',
    JO: 'contoh: Amman, Zarqa, Irbid',
    KW: 'contoh: Kuwait City',
    LB: 'contoh: Beirut, Tripoli',
    OM: 'contoh: Muscat, Salalah',
    QA: 'contoh: Doha',
    YE: 'contoh: Sanaa, Aden',
    SY: 'contoh: Damascus, Aleppo',
    PS: 'contoh: Gaza, Ramallah',
    MA: 'contoh: Casablanca, Rabat, Marrakech',
    DZ: 'contoh: Algiers, Oran, Constantine',
    TN: 'contoh: Tunis, Sfax',
    LY: 'contoh: Tripoli, Benghazi',
    SD: 'contoh: Khartoum, Omdurman',
    SO: 'contoh: Mogadishu, Hargeisa',
    NG: 'contoh: Lagos, Kano, Abuja',
    SN: 'contoh: Dakar, Touba',
    ET: 'contoh: Addis Ababa, Dire Dawa',
    UZ: 'contoh: Tashkent, Samarkand, Bukhara',
    KZ: 'contoh: Almaty, Astana',
    TM: 'contoh: Ashgabat',
    TJ: 'contoh: Dushanbe',
    KG: 'contoh: Bishkek',
    AZ: 'contoh: Baku',
    AL: 'contoh: Tirana, Durres',
    BA: 'contoh: Sarajevo, Mostar',
    XK: 'contoh: Pristina',
    GB: 'contoh: London, Birmingham, Manchester',
    DE: 'contoh: Berlin, Hamburg, Munich',
    FR: 'contoh: Paris, Marseille, Lyon',
    NL: 'contoh: Amsterdam, Rotterdam',
};

function updateCityPlaceholder(select) {
    const hint = document.getElementById('city-hint');
    const cityInput = document.getElementById('city');
    const val = select.value;
    if (cityExamples[val]) {
        hint.textContent = cityExamples[val];
        cityInput.placeholder = cityExamples[val].replace('contoh: ', '').split(',')[0].trim();
    } else {
        hint.textContent = 'Pilih negara dulu untuk melihat contoh kota';
        cityInput.placeholder = 'Ketik nama kota...';
    }
}
</script>

@endsection
