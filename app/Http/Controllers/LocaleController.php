<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $locale = request('locale');
        session()->put('locale', $locale);
        return $request->inertia() ? back() : response()->json(compact('locale'));
    }
}
