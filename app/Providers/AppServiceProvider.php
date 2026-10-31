<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('files', function () {
            return new class extends Filesystem {
                public function replace($path, $content, $mode = null)
                {
                    clearstatcache(true, $path);
                    $path = realpath($path) ?: $path;
                    file_put_contents($path, $content);
                    if (! is_null($mode)) {
                        @chmod($path, $mode);
                    }
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Authenticate::redirectUsing(function ($request) {
            if (Route::has('login')) {
                return route('login');
            }

            abort(403, 'Akses ditolak. Silakan login terlebih dahulu dengan akun resmi untuk mengakses layanan ini.');
        });

        Gate::define('akses-surat-warga', function (?User $user) {
            return ($user && $user->isWarga() && ! empty($user->warga_id))
                ? Response::allow()
                : Response::deny('Akses ditolak. Layanan mandiri pengajuan surat ini khusus untuk akun Warga yang telah login.');
        });

        Gate::define('akses-surat-admin', function (?User $user) {
            return ($user && $user->isAdmin())
                ? Response::allow()
                : Response::deny('Akses ditolak. Panel pelayanan surat ini khusus untuk Admin / Perangkat Desa / Kepala Desa.');
        });
    }
}
