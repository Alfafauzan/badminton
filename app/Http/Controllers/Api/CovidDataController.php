<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CovidDataController extends Controller
{
    public function showDashboard(Request $request)
    {
        // 1. Mengirim request ke API
        $apiUrl = 'https://disease.sh/v3/covid-19/historical/ID, MY?lastdays=all';

        $response = Http::timeout(10)->get($apiUrl);

        if ($response->failed()) {
            return response('Gagal mengambil data dari sumber eksternal.', 500);
        }
        $countries = $response->json();
        if (array_key_exists('country', $countries)) {
            $countries = [$countries]; // Jadikan array jika tunggal
        }
        // 2. Prepare array untuk menyimpan data final
        $flatData = [];

        // 3. Loop masing-masing negara
        foreach ($countries as $country) {
            if (!isset($country['timeline']['cases'])) {
                continue;
            }

            foreach ($country['timeline']['cases'] as $date => $cases) {
                $flatData[] = [
                    'date' => date('Y-m-d', strtotime($date)),
                    'country' => $country['country'],
                    'cases' => $cases,
                    'deaths' => $country['timeline']['deaths'][$date] ?? 0,
                    'recovered' => $country['timeline']['recovered'][$date] ?? 0,
                ];
            }
        }
        // 4. Sort berdasarkan tanggal (desc)
        $flatData = collect($flatData)->sortByDesc('recovered')->values();

        // 5. Pagination
        $perPage = 25;
        $currentPage = $request->input('page', 1);
        $currentItems = $flatData->forPage($currentPage, $perPage);
        $paginated = new LengthAwarePaginator($currentItems, $flatData->count(), $perPage, $currentPage, ['path' => $request->url(), 'query' => $request->query()]);

        // 6. Kirim ke view
        return view('api', ['timeSeriesData' => $paginated]);
    }
}
