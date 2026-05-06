<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AladhanService;
use App\Services\QuranService;

class PrayerController extends Controller
{
    protected $aladhanService;
    protected $quranService;

    public function __construct(AladhanService $aladhanService, QuranService $quranService)
    {
        $this->aladhanService = $aladhanService;
        $this->quranService   = $quranService;
    }

    public function index()
    {
        return view('prayer.index');
    }

    public function show(Request $request)
    {
        $request->validate([
            'city'    => 'required|string|max:100',
            'country' => 'nullable|string|max:5',
        ]);

        $city    = $request->input('city');
        $country = $request->input('country', 'ID');

        $prayerData = $this->aladhanService->getTimings($city, $country);
        $quranData  = $this->quranService->getDailyAyah();

        if (!$prayerData['success']) {
            return back()
                ->withInput()
                ->withErrors(['city' => 'Kota "' . $city . '" tidak ditemukan. Coba nama kota lain.']);
        }

        return view('prayer.result', [
            'city'       => $city,
            'country'    => $country,
            'timings'    => $prayerData['timings'],
            'date'       => $prayerData['date'],
            'nextPrayer' => $this->getNextPrayer($prayerData['timings']),
            'ayah'       => $quranData,
        ]);
    }

    private function getNextPrayer(array $timings): array
    {
        $now    = now()->format('H:i');
        $order  = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
        $labels = [
            'Fajr'    => 'Subuh',
            'Dhuhr'   => 'Dzuhur',
            'Asr'     => 'Ashar',
            'Maghrib' => 'Maghrib',
            'Isha'    => 'Isya',
        ];

        foreach ($order as $prayer) {
            if (isset($timings[$prayer]) && $timings[$prayer] > $now) {
                return [
                    'name'  => $labels[$prayer],
                    'time'  => $timings[$prayer],
                ];
            }
        }

        // Semua sholat sudah lewat — berikutnya Subuh esok
        return [
            'name' => 'Subuh (besok)',
            'time' => $timings['Fajr'],
        ];
    }
}
