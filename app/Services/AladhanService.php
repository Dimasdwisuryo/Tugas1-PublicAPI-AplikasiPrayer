<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AladhanService
{
    private string $baseUrl = 'https://api.aladhan.com/v1';

    // Method 11 = JAKIM (Malaysia/Indonesia)
    private int $method = 11;

    public function getTimings(string $city, string $country = 'ID'): array
    {
        try {
            $response = Http::timeout(10)->get("{$this->baseUrl}/timingsByCity", [
                'city'    => $city,
                'country' => $country,
                'method'  => $this->method,
            ]);

            if ($response->failed() || $response->json('code') !== 200) {
                return ['success' => false];
            }

            $data     = $response->json('data');
            $timings  = $data['timings'];
            $dateInfo = $data['date'];

            // Ambil hanya 5 waktu sholat utama
            $prayerKeys = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
            $filtered   = array_intersect_key($timings, array_flip($prayerKeys));

            return [
                'success' => true,
                'timings' => $filtered,
                'date'    => [
                    'gregorian' => $dateInfo['readable'],
                    'hijri'     => $dateInfo['hijri']['date']
                                   . ' '
                                   . $dateInfo['hijri']['month']['en']
                                   . ' '
                                   . $dateInfo['hijri']['year']
                                   . ' H',
                    'day'       => $dateInfo['hijri']['weekday']['en'],
                ],
            ];

        } catch (\Exception $e) {
            Log::error('AladhanService error: ' . $e->getMessage());
            return ['success' => false];
        }
    }
}
