<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // \URL::forceScheme('https');

        Paginator::useBootstrapFive();

        Blade::directive('convert', function ($money) {
            return "<?php echo number_format($money, 2); ?>";
        });
        
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $user = User::find(Auth::user()->id);
                View::share([
                    'userGlobal' => $user,
                    'userImage' => $user->getImage(),
                ]);
            } else {
                $user = User::find(1);
                View::share([
                    'userGlobal' => $user,
                    'userImage' => $user->getImage(),
                ]);
            }
        });
    }
}
