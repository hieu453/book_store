<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Inertia\Middleware;
use App\Models\Category;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ?? null,
            ],
            'categories' => Category::all(),
            'cartNumber' => $request->user() ? Cart::where('user_id', $request->user()->id)->sum('quantity') : null,
        ];
    }
}
