<?php

namespace App\Http\Controllers;

use App\Http\Resources\TourCollection;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, Travel $travel)
    {
        $query = Tour::where('travelId', '=', $travel->id);

        if ($request->get('priceFrom')) {
            $query->where('price', '>=', $request->get('priceFrom'));
        }
        if ($request->get('priceTo')) {
            $query->where('price', '<=', $request->get('priceTo'));
        }
        if ($request->get('dateFrom')) {
            $query->where('startingDate', '>=', $request->get('dateFrom') . ' 00:00:00');
        }
        if ($request->get('dateTo')) {
            $query->where('startingDate', '<=', $request->get('dateTo') . ' 00:00:00');
        }
        if ($request->get('sortBy') == 'price') {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('startingDate', 'asc');
        }

        return new TourCollection($query->paginate());
    }
}
