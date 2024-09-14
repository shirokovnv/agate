<?php

declare(strict_types=1);

namespace App\Providers;

use App\Gateway\Contracts\Routing\PatternMatcherInterface;
use App\Gateway\Contracts\Routing\ReqRespFactoryInterface;
use App\Gateway\Contracts\Routing\RouterInterface;
use App\Gateway\Contracts\Schema\Registry\ActionRegistryInterface;
use App\Gateway\Contracts\Schema\Registry\ServiceRegistryInterface;
use App\Gateway\Contracts\Schema\Validation\ValidationWrapperInterface;
use App\Gateway\Contracts\UuidFactoryInterface;
use App\Gateway\Contracts\Worker\WorkerFactoryInterface;
use App\Gateway\Routing\PatternMatcher;
use App\Gateway\Routing\ReqRespFactory;
use App\Gateway\Routing\Router;
use App\Gateway\Schema\Registry\ActionRegistry;
use App\Gateway\Schema\Registry\ServiceRegistry;
use App\Gateway\Schema\Validation\ValidationWrapper;
use App\Gateway\UuidFactory;
use App\Gateway\Worker\WorkerFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ActionRegistryInterface::class, ActionRegistry::class);
        $this->app->bind(ServiceRegistryInterface::class, ServiceRegistry::class);
        $this->app->bind(PatternMatcherInterface::class, PatternMatcher::class);
        $this->app->bind(ValidationWrapperInterface::class, ValidationWrapper::class);

        $this->app->singleton(UuidFactoryInterface::class, UuidFactory::class);
        $this->app->singleton(ReqRespFactoryInterface::class, ReqRespFactory::class);
        $this->app->singleton(RouterInterface::class, Router::class);
        $this->app->singleton(WorkerFactoryInterface::class, WorkerFactory::class);
    }
}
