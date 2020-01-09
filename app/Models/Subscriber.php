<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Defines a subsriber.
 */
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

    /** @var array */
    protected $auditExclude = [
        'secret',
    ];

    /**
     * Builds the is_confirmed attribute to determine if the subscription has been confirmed.
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsConfirmedAttribute()
    {
        return !empty($this->confirmed_at);
    }

    /**
     * Builds the subscription management URL.
     *
     * @return string
     */
    public function getManageSubscriptionUrlAttribute()
    {
        return route('subscriber.edit', [
            'uuid'   => urlencode($this->uuid),
            'secret' => urlencode($this->secret),
        ]);
    }

    /**
     * Builds the subscription confirm URL.
     *
     * @return string
     */
    public function getConfirmSubscriptionUrlAttribute()
    {
        return route('subscriber.confirm', [
            'uuid'   => urlencode($this->uuid),
            'secret' => urlencode($this->secret),
        ]);
    }
}
