<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use Illuminate\Console\Command;

final class DispatchWelcomeEmail extends Command
{
    protected $signature = 'email:welcome {user_id}';

    protected $description = 'Dispatch welcome email job for a given user id';

    public function handle(): int
    {
        $user = User::findOrFail($this->argument('user_id'));
        SendWelcomeEmailJob::dispatch($user);
        $this->info('Job dispatched');

        return self::SUCCESS;
    }
}
