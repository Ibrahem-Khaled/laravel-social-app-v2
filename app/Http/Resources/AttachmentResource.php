<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'            => (string) $this->id,
            'original_name' => $this->original_name ?? basename($this->path),
            'mime'          => $this->mime,
            'size'          => $this->size,
            'url'           => $this->when($this->disk === 'public', url('storage/' . $this->path)),
            'download_url'  => route('api.attachments.download', $this->resource),
            'uploaded_by'   => $this->uploader?->only(['id', 'name']),
            'created_at'    => $this->created_at,
        ];
    }
}
