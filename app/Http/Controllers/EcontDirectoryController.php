<?php

namespace App\Http\Controllers;

use App\Domain\Econt\Services\EcontDirectory;
use Illuminate\Http\Request;

class EcontDirectoryController extends Controller
{
    public function __construct(private readonly EcontDirectory $directory) {}

    // GET /api/econt/cities?q=Соф
    public function cities(Request $request)
    {
        $q = $request->query('q');
        return response()->json($this->directory->cities($q)->map->toArray());
    }

    // GET /api/econt/offices?city=София
    public function offices(Request $request)
    {
        $city = (string) $request->query('city', '');
        abort_if($city === '', 422, 'city е задължителен');

        return response()->json($this->directory->officesByCity($city)->map->toArray());
    }
}
