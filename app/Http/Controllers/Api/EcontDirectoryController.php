<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Shipping\EcontDirectoryService;

class EcontDirectoryController extends Controller
{
    /**
     * API endpoint for searching cities in Econt's directory.
     *
     * Query params:
     * - q (string, optional)  → search term for filtering cities
     * - limit (int, optional) → maximum results, default 50
     */
    public function cities(Request $request, EcontDirectoryService $svc)
    {
        $q     = $request->string('q')->toString();   // safe extraction of query param "q"
        $limit = (int) $request->integer('limit', 50); // fallback to 50 if missing
        return response()->json($svc->searchCities($q, $limit));
    }

    /**
     * API endpoint for fetching offices for a given city.
     *
     * Query params:
     * - city_id (int, required) → Econt city ID (internal PK, not name)
     * - q (string, optional)    → search term for filtering offices by name/code
     * - limit (int, optional)   → maximum results, default 200
     */
    public function offices(Request $request, EcontDirectoryService $svc)
    {
        $cityId = (int) $request->integer('city_id');
        abort_if($cityId <= 0, 422, 'Missing or invalid city_id'); // input validation

        $q     = $request->string('q')->toString();
        $limit = (int) $request->integer('limit', 200);

        return response()->json($svc->officesByCity($cityId, $q, $limit));
    }

    /**
     * API endpoint for fetching streets in a given city.
     *
     * Query params:
     * - city_id (int, required) → Econt city ID
     * - q (string, optional)    → search term for filtering streets
     * - limit (int, optional)   → maximum results, default 100
     */
    public function streets(Request $r, EcontDirectoryService $svc)
    {
        $cityId = (int) $r->integer('city_id');
        abort_if($cityId <= 0, 422, 'Missing or invalid city_id'); // validation

        $q     = $r->string('q')->toString();
        $limit = (int) $r->integer('limit', 100);

        return response()->json($svc->streetsByCity($cityId, $q, $limit));
    }
}
