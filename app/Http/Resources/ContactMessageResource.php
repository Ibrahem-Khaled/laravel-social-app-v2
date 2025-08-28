<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'        => (string) $this->id,
            'from'      => $this->user
                ? ['type' => 'user', 'id' => $this->user->id, 'name' => $this->user->name]
                : ['type' => 'guest', 'name' => $this->guest_name, 'email' => $this->guest_email, 'phone' => $this->guest_phone],
            'subject'   => $this->subject,
            'message'   => $this->message,
            'status'    => $this->status->value,
            'priority'  => $this->priority->value,
            'category'  => $this->category->value,
            'source'    => $this->source->value,
            'assignee'  => $this->assignee?->only(['id', 'name', 'email']),
            'ip'        => $this->ip_address,
            'user_agent' => $this->user_agent,
            'replied_at' => $this->replied_at,
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'created_at' => $this->created_at,
        ];
    }
}
