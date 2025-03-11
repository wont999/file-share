<?php

namespace App\Providers;

use App\Models\File;
use App\Models\FileLink;
use App\Policies\FileLinkPolicy;
use App\Policies\FilePolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(File::class, FilePolicy::class);
        Gate::policy(FileLink::class, FileLinkPolicy::class);
    }
}
