<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

class TravelController extends Controller
{
    public function index()
    {
        $travels = Travel::where('is_public', true)
            ->paginate(
                config('api.paginationPerPage.travels')
            );

        return TravelResource::collection($travels);
    }
}
