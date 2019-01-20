<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Page;
use App\Service;
use App\Portfolio;
use App\Policies\PagePolicy;
use App\Policies\ServicePolicy;
use App\Policies\PortfolioPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      Page::class => PagePolicy::class,
      Portfolio::class => PortfolioPolicy::class,
      Service::class => ServicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
