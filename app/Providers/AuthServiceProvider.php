<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */

    public function boot()
    {
        Gate::define('admin', function ($user) {
        return $user->role === 'admin';
        });
        Gate::define('manage-course', function ($user, $curso) {
            return $curso->professor_id === $user->id;
        });

        Gate::define('manage-discipline', function ($user, $disciplina) {
            // A disciplina pertence a um curso, logo...
            return $disciplina->curso->professor_id === $user->id;
        });
}


}