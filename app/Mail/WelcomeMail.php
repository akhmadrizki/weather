<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

final class WelcomeMail extends Mailable
{
    public function __construct(public readonly User $user) {}

    public function build(): self
    {
        return $this->subject('Welcome')->view('emails.welcome');
    }
}
