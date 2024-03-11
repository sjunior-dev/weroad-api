<?php

namespace App\Http\Controllers;

use App\Http\Resources\TravelCollection;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TravelController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'unique:travels', 'max:255'],
            'description' => ['required'],
            'numberOfDays' => ['required'],
            'public' => ['required'],
        ]);

        $travel = Travel::create($request->all());
        return new TravelResource($travel);
    }
    public function index(Request $request)
    {
        return new TravelCollection(Travel::paginate());
    }

}
