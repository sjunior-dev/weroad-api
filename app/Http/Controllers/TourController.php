<?php

namespace App\Http\Controllers;

use App\Http\Resources\TourCollection;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Travel $travel)
    {
        return new TourCollection($travel->tours);
    }

    public function store(Request $request, Travel $travel)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'unique:tours', 'max:255'],
            'startingDate' => ['required'],
            'endingDate' => ['required'],
            'price' => ['required', 'gt:0'],
        ]);

        $tour = Tour::create($request->all()+['travelId' => $travel->id]);

        return new TourResource($tour);
    }

    public function update(Request $request, Tour $tour)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'startingDate' => ['required'],
            'endingDate' => ['required'],
            'price' => ['required', 'gt:0'],
        ]);

        $tour->update($request->all());

        return new TourResource($tour);
    }

}
