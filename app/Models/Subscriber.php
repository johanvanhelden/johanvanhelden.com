<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Subscriber extends Model
{
    use HasFactory, LogsActivity;

    public static bool $logFillable = true;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'email',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    /** @var array<int, string> */
    protected $hidden = [
        'secret',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept([
                'secret',
                'updated_at',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

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
