<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Defines a project.
 */
class ProjectResource extends Resource
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
