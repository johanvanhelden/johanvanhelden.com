<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Audit\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use OwenIt\Auditing\Models\Audit as VendorModel;

class Audit extends VendorModel
{
    private static function createCustomDefaults(bool $fillRequestData): self
    {
        $audit = new self();

        $audit->old_values = [];
        $audit->new_values = [];
        $audit->created_at = Carbon::now();

        if ($fillRequestData) {
            $audit->ip_address = Request::ip();
            $audit->user_agent = Request::userAgent();
            $audit->url = Request::fullUrl();
        }

        return $audit;
    }

    public static function createForLogin(User $user): void
    {
        $audit = self::createCustomDefaults(true);

        $audit->event = Event::LOGGED_IN;

        $audit->auditable()->associate($user);
        $audit->user()->associate($user);

        $audit->save();
    }

    public static function createForLogout(User $user): void
    {
        $audit = self::createCustomDefaults(true);

        $audit->event = Event::LOGGED_OUT;

        $audit->auditable()->associate($user);
        $audit->user()->associate($user);

        $audit->save();
    }
}
