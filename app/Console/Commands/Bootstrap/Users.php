<?php

namespace App\Console\Commands\Bootstrap;

use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

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
        $isProduction = App::environment(config('constants.environment.production'));

        foreach ($defaultUsers as $user) {
            if ($isProduction && !$user['on-production']) {
                $this->info('Skipping user ' . $user['data']['email'] . ' on production.');

                continue;
            }

            $hasDefaultUser = User::where('email', $user['data']['email'])->exists();
            if (!$hasDefaultUser) {
                $newUser = $this->userService->create($user['data']);

                $newUser->email_verified_at = Carbon::now();
                $newUser->save();
            }

            foreach ($user['roles'] as $role) {
                User::where('email', $user['data']['email'])->first()->assignRole($role);
            }
        }

        $this->info('Bootstrapping users done');
    }
}
