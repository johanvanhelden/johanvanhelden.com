<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @extends JsonResource<\App\Models\Project> */
class ProjectResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function toArray($request): array
    {
        return [
            'slug'         => $this->slug,
            'name'         => $this->name,
            'excerpt'      => $this->excerpt,
            'content'      => $this->content,
            'external_url' => $this->url,

            'publish_at' => $this->publish_at->toW3cString(),
            'updated_at' => $this->updated_at->toW3cString(),

            'is_recently_updated' => $this->is_recently_updated,
            'is_updated'          => $this->is_updated,
        ];
    }
}
