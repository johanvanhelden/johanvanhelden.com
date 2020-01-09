<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Storage;

/**
 * Defines a tool.
 */
class ToolResource extends Resource
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
            'name'         => $this->name,
            'image_url'    => Storage::disk('tools')->url($this->image),
            'external_url' => $this->url,
        ];
    }
}
