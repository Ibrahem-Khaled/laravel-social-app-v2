<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->related?->user?->id,
            'user' => $this->related?->user?->name ?? 'مستخدم',
            'image' => $this->related?->user?->avatar_url,
            'action' => $this->message,
            'is_read' => $this->is_read,
            'time' => $this->created_at->diffForHumans(),
            'related_id' => $this->related_id,
            'related_type' => $this->related_type,
        ];
    }
}
