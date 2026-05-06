<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuranService
{
    private string $baseUrl = 'https://api.alquran.cloud/v1';

    // Total ayat dalam Al-Quran
    private int $totalAyah = 6236;

    public function getDailyAyah(): array
    {
        // Nomor ayat berganti otomatis setiap hari
        $dayOfYear = (int) now()->format('z') + 1;
        $ayahNumber = ($dayOfYear % $this->totalAyah) + 1;

        try {
            // Ambil teks Arab
            $arabicResponse = Http::timeout(10)
                ->get("{$this->baseUrl}/ayah/{$ayahNumber}");

            // Ambil terjemahan Indonesia
            $indonesianResponse = Http::timeout(10)
                ->get("{$this->baseUrl}/ayah/{$ayahNumber}/id.indonesian");

            if ($arabicResponse->failed() || $indonesianResponse->failed()) {
                return $this->fallback();
            }

            $arabicData    = $arabicResponse->json('data');
            $indonesianData = $indonesianResponse->json('data');

            return [
                'success'    => true,
                'arabic'     => $arabicData['text'],
                'indonesian' => $indonesianData['text'],
                'surah'      => $arabicData['surah']['englishName'],
                'surah_id'   => $arabicData['surah']['name'],
                'ayah_num'   => $arabicData['numberInSurah'],
                'surah_num'  => $arabicData['surah']['number'],
            ];

        } catch (\Exception $e) {
            Log::error('QuranService error: ' . $e->getMessage());
            return $this->fallback();
        }
    }

    private function fallback(): array
    {
        return [
            'success'    => false,
            'arabic'     => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ',
            'indonesian' => 'Dengan nama Allah Yang Maha Pengasih, Maha Penyayang.',
            'surah'      => 'Al-Fatihah',
            'surah_id'   => 'الفاتحة',
            'ayah_num'   => 1,
            'surah_num'  => 1,
        ];
    }
}
