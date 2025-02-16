<?php

namespace App\Providers;

use App\Models\Team;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;

class TeamRoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define team roles
        Jetstream::role('admin', 'Administrator', [
            'create',
            'read',
            'update',
            'delete',
            'view-reports',
            'manage-team',
        ])->description('Administrator users can perform any action.');

        Jetstream::role('mentor', 'Mentor', [
            'read',
            'create',
            'update',
            'view-reports',
        ])->description('Mentor users have the ability to read, create, and update.');

        Jetstream::role('student', 'Student', [
            'read',
        ])->description('Student users have the ability to read.');

        // Define permissions
        Gate::define('view-meetings', function ($user, $team) {
            if (!$team instanceof Team && !is_null($team)) {
                $team = Team::find($team);
            }
            return $team && $user->belongsToTeam($team);
        });

        Gate::define('manage-meetings', function ($user, $team) {
            if (!$team instanceof Team && !is_null($team)) {
                $team = Team::find($team);
            }
            return $team && ($user->hasTeamRole($team, 'admin') || 
                   $user->hasTeamRole($team, 'mentor'));
        });

        Gate::define('view-tasks', function ($user, $team) {
            if (!$team instanceof Team && !is_null($team)) {
                $team = Team::find($team);
            }
            return $team && $user->belongsToTeam($team);
        });

        Gate::define('manage-tasks', function ($user, $team) {
            if (!$team instanceof Team && !is_null($team)) {
                $team = Team::find($team);
            }
            return $team && ($user->hasTeamRole($team, 'admin') || 
                   $user->hasTeamRole($team, 'mentor'));
        });

        Gate::define('view-trainings', function ($user, $team) {
            if (!$team instanceof Team && !is_null($team)) {
                $team = Team::find($team);
            }
            return $team && $user->belongsToTeam($team);
        });

        Gate::define('manage-trainings', function ($user, $team) {
            if (!$team instanceof Team && !is_null($team)) {
                $team = Team::find($team);
            }
            return $team && ($user->hasTeamRole($team, 'admin') || 
                   $user->hasTeamRole($team, 'mentor'));
        });
    }
} 