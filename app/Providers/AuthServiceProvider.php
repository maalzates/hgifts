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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // This checks if the user has the "Admin" role. 
        Gate::define('admin', function ($user){
            $user_pivot = $user->roles()->pluck('role_id')->toArray();
            if (in_array('1', $user_pivot)){
                return true;
            }
            return false;
        });

        // This prevent access for regular users to routes which they have no access. Example. campaign show that is not active or subscribed. 
        Gate::resource('campaigns', CampaignPolicy::class);
    }
}
