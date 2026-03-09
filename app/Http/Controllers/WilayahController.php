<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    private string $baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';
    private int $cacheDays = 7;

    private function fetchAndCache(string $key, string $endpoint): JsonResponse
    {
        $data = Cache::remember("wilayah_{$key}", now()->addDays($this->cacheDays), function () use ($endpoint) {
            try {
                $response = Http::timeout(10)->get($this->baseUrl . $endpoint);
                if ($response->successful()) {
                    return $response->json();
                }
                return [];
            } catch (\Exception $e) {
                return [];
            }
        });

        return response()->json($data);
    }

    public function provinces(): JsonResponse
    {
        return $this->fetchAndCache('provinces', '/provinces.json');
    }

    public function regencies(string $provinceId): JsonResponse
    {
        return $this->fetchAndCache("regencies_{$provinceId}", "/regencies/{$provinceId}.json");
    }

    public function districts(string $regencyId): JsonResponse
    {
        return $this->fetchAndCache("districts_{$regencyId}", "/districts/{$regencyId}.json");
    }

    public function villages(string $districtId): JsonResponse
    {
        return $this->fetchAndCache("villages_{$districtId}", "/villages/{$districtId}.json");
    }
}
