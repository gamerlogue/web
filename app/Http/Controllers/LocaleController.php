<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $locale = $request->input('locale');
        session()->put('locale', $locale);

        return $request->inertia() ? back() : response()->json(compact('locale'));
    }
}
