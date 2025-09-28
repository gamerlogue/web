<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'user' => fn () => $request->user()?->only('id', 'name', 'first_name', 'last_name', 'nickname', 'email', 'picture'),
            'flash' => [
                'status' => fn () => $request->session()->get('status'),
                'status_multiline' => fn () => $request->session()->get('status_multiline'),
                'status_persistent' => fn () => $request->session()->get('status_persistent'),
            ],
        ];
    }
}
