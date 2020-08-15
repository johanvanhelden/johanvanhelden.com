<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @extends JsonResource<\App\Models\Subscriber> */
class SubscriberResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request): array
    {
        return [
            'uuid'   => $this->uuid,
            'name'   => $this->name,
            'email'  => $this->email,
            'secret' => $this->secret,
        ];
    }
}
