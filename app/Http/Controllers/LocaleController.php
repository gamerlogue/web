<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LocaleUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class LocaleController
{
    public function update(LocaleUpdateRequest $request): JsonResponse|RedirectResponse
    {
        $locale = $request->validated('locale');
        session()->put('locale', $locale);

        return $request->inertia() ? back() : response()->json(compact('locale'));
    }
}
