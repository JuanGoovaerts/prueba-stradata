<?php

namespace App\Http\Controllers;

use App\PublicFigure;
use App\StringCompare;
use Illuminate\Http\Request;

class NameSimilarityController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validación
        $request->validate([
           'name' => ['required', 'string'],
           'rating' => ['required', 'integer', 'max:100', 'min:0']
        ]);
        $persons = PublicFigure::search($request->name)->get();
        $persons = (new StringCompare($request->name))
            ->withPublicFigures($persons)
            ->sortByDesc('raking')
            ->where('raking', '>=', $request->rating)
            ->take(25)
            ->values();
        return response()->json([
           'persons' => $persons,
           'count' => count($persons),
           'ok' => true,
        ], 200);
    }
}
