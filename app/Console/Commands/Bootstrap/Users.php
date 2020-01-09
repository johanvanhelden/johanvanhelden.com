<?php

namespace App\Console\Commands\Bootstrap;

use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Bootstraps the users.
 */
class Users extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bootstrap:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bootstraps the users.';

    /** @var UserService */
    protected $userService;

    /**
     * Create a new command instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Bootstrapping users...');

        $defaultUsers = config('defaults.users');
        $isFirstBootstrap = User::all()->isEmpty();

        foreach ($defaultUsers as $user) {
            $isProduction = app()->environment(config('constants.environment.production'));

            if ($isProduction && !$user['on-production']) {
                $this->info('Skipping user ' . $user['data']['email'] . ' on production.');

                continue;
            }

            $hasDefaultUser = User::whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            })->exists();

            if (!$hasDefaultUser || $isFirstBootstrap) {
                $newUser = $this->userService->create($user['data']);

                $newUser->email_verified_at = Carbon::now();
                $newUser->save();

                foreach ($user['roles'] as $role) {
                    $newUser->assignRole($role);
                }
            }
        }

        $this->info('Bootstrapping users done');
    }
}
