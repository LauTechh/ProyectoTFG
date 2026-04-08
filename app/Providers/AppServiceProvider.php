<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Importante
use Illuminate\Support\Facades\Auth; // Importante
use App\Models\Amigo; // Asegúrate de que tu modelo se llame asi

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
        // Compartimos la variable 'solicitudesPendientes' con TODAS las vistas
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $conteo = Amigo::where('amigo_id', Auth::id())
                    ->where('estado', 'pendiente')
                    ->count();
                $view->with('solicitudesPendientes', $conteo);
            } else {
                $view->with('solicitudesPendientes', 0);
            }
        });
    }
}
