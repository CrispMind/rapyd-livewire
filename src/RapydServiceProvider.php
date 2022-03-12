<?php

namespace Zofe\Rapyd;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Zofe\Rapyd\Commands\RapydCommand;
use Zofe\Rapyd\Demo\Http\Livewire\ArticlesTable;
use Zofe\Rapyd\Demo\Http\Livewire\UsersTable;
use Zofe\Rapyd\View\Components\Forms\Text;

class RapydServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/rapyd-livewire.php' => config_path('rapyd-livewire.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/rapyd-livewire'),
            ], 'views');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/rapyd-livewire'),
            ], 'public');

            $this->publishes([
                __DIR__.'/Demo/routes/rapyd.php' => base_path('routes/rapyd.php'),
            ], 'routes');

            $this->commands([
                RapydCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'rapyd');
        $this->loadViewsFrom(__DIR__ . '/Demo/resources/views', 'rapyd-demo');

        if (file_exists(base_path('routes/rapyd.php')))
        {
            $this->loadRoutesFrom(base_path('routes/rapyd.php'));
        } else {
            $this->loadRoutesFrom(__DIR__.'/Demo/routes/rapyd.php');
        }

        Blade::component('rpd-input', Text::class);

        Livewire::component('rapyd::demo-articles-table', ArticlesTable::class);
        Livewire::component('rapyd::demo-users-table', UsersTable::class);


    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/rapyd-livewire.php', 'rapyd-livewire');
    }

}
