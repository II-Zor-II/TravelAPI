<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToursListRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

class TourController extends Controller
{
    public function index(Travel $travel, ToursListRequest $request) 
    {
        $tours = $travel->tours()
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo * 100);
            })
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('start_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('end_date', '<=', $request->dateTo);
            })
            ->when($request->sortBy, function ($query) use ($request) {
                if (! in_array($request->sortBy, ['price'])
                    || (! in_array($request->sortOrder, ['asc', 'desc']))) {
                    return;
                }

                $query->orderBy($request->sortBy, $request->sortOrder);
            })
            ->orderBy('start_date')
            ->paginate(
                config('api.paginationPerPage.tours')
            );

        return TourResource::collection($tours);
    }
}
