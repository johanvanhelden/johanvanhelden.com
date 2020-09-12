<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Subscriber extends Model
{
    use HasFactory, LogsActivity;

    public static bool $logFillable = true;

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
