<?php

declare(strict_types=1);

namespace App\Console\Commands\Bootstrap;

use App\Actions\User\AssignRole;
use App\Actions\User\CreateUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class Users extends Command
{
    /** @var string */
    protected $signature = 'bootstrap:users';

    /** @var string */
    protected $description = 'Bootstraps the users.';

    public function handle(): void
    {
        $this->info('Bootstrapping users...');

        $defaultUsers = config('bootstrap.users');
        $isProduction = App::environment(config('constants.environment.production'));

        foreach ($defaultUsers as $user) {
            if ($isProduction && !$user['on-production']) {
                $this->info('Skipping user ' . $user['data']['email'] . ' on production.');

                continue;
            }

            $defaultUser = User::whereEmail($user['data']['email'])->first();
            if (empty($defaultUser)) {
                $data = $user['data'];
                $data['email_verified_at'] = Carbon::now();

                App::make(CreateUser::class)->execute($data);

                $defaultUser = User::whereEmail($user['data']['email'])->first();
            }

            foreach ($user['roles'] as $role) {
                App::make(AssignRole::class)->execute($defaultUser, $role);
            }
        }

        $this->info('Bootstrapping users done');
    }
}
