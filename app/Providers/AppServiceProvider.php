<?php

namespace App\Providers;

use App\Models\Resource;
use App\Policies\ResourcePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Resource::class, ResourcePolicy::class);

        // Ensure the dashboard view always has the latest counts for the
        // authenticated user, even if a package registers a plain view route.
        View::composer('dashboard', function ($view) {
            $userId = Auth::id();

            $baseQuery = \App\Models\Resource::where('user_id', $userId);

            $view->with([
                'activeListings' => (clone $baseQuery)->where('status', 'active')->count(),
                'pausedListings' => (clone $baseQuery)->where('status', 'paused')->count(),
                'totalListings' => (clone $baseQuery)->count(),
                'categoriesUsed' => (clone $baseQuery)->distinct('category_id')->count('category_id'),
                'lastUpdatedAt' => (clone $baseQuery)->orderByDesc('updated_at')->value('updated_at'),
                'recentResources' => (clone $baseQuery)->with('category')->orderByDesc('updated_at')->limit(5)->get(),
            ]);
        });
    }
}
