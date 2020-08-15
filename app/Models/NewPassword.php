<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class NewPassword extends Model
{
    public static function createToken(User $user): string
    {
        $user->newPasswords->each->delete();

        $token = new self();
        $token->token = hash_hmac('sha256', Str::random(40), config('app.key'));

        $user->newPasswords()->save($token);

        return $token->token;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
