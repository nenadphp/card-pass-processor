<?php

namespace App\Providers;

use App\Http\Requests\PasswordGeneratorRequest;
use App\Models\Card;
use App\Services\CardProcessorService;
use App\Services\Factories\PasswordStrengthGeneratorFactory;
use App\Services\Interfaces\CardProcessorInterface;
use App\Services\Interfaces\PasswordGeneratorInterface;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CardProcessorInterface::class, function () {
            return new CardProcessorService(
                new Card()
            );
        });

        $this->app->bind(PasswordGeneratorInterface::class, function () {
            return PasswordStrengthGeneratorFactory::create(
                app(PasswordGeneratorRequest::class)->get('strength'),
                app(PasswordGeneratorRequest::class)->get('length'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
