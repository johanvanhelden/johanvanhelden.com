<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Defines a user.
 */
class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use Notifiable, HasRoles, AuditTrait;

    /** @var array */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /** @var array */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @var array */
    protected $auditExclude = [
        'password',
        'remember_token',
    ];

    /** @var array */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation with the new passwords.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newPasswords()
    {
        return $this->hasMany(NewPassword::class);
    }
}
