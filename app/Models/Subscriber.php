<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Subscriber extends Model implements Auditable
{
    use AuditTrait;

    /** @var array */
    protected $fillable = [
        'name',
        'email',
    ];

    /** @var array */
    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    /** @var array */
    protected $hidden = [
        'secret',
    ];

    protected array $auditExclude = [
        'secret',
    ];

    /** @SuppressWarnings(PHPMD.BooleanGetMethodName) */
    public function getIsConfirmedAttribute(): bool
    {
        return !empty($this->confirmed_at);
    }

    public function getManageSubscriptionUrlAttribute(): string
    {
        return route('subscriber.edit', [
            'uuid'   => urlencode($this->uuid),
            'secret' => urlencode($this->secret),
        ]);
    }

    public function getConfirmSubscriptionUrlAttribute(): string
    {
        return route('subscriber.confirm', [
            'uuid'   => urlencode($this->uuid),
            'secret' => urlencode($this->secret),
        ]);
    }
}
