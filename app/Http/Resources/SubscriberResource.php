<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Defines a subscriber.
 */
class SubscriberResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request)
    {
        return [
            'uuid'   => $this->uuid,
            'name'   => $this->name,
            'email'  => $this->email,
            'secret' => $this->secret,
        ];
    }
}
