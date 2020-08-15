<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @extends JsonResource<\App\Models\Tool> */
class ToolResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request): array
    {
        return [
            'name'         => $this->name,
            'image_url'    => Storage::disk('tools')->url($this->image),
            'external_url' => $this->url,
        ];
    }
}
