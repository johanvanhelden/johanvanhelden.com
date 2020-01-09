<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Defines a new password token.
 */
class NewPassword extends Model
{
    /**
     * Create a new password token.
     *
     * @param User $user
     *
     * @return string
     */
    public static function createToken(User $user)
    {
        $user->newPasswords->each->delete();

        $token = new self();
        $token->token = hash_hmac('sha256', Str::random(40), config('app.key'));

        $user->newPasswords()->save($token);

        return $token->token;
    }

    /**
     * Relation with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
