<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * تحويل المورد إلى مصفوفة.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reason' => $this->reason,
            'details' => $this->details,
            'status' => $this->is_hidden ? 'تمت المراجعة' : 'قيد المراجعة',
            'reported_item' => [
                'type' => $this->related_type,
                'id' => $this->related_id,
            ],
            // تضمين بيانات المستخدم الذي أبلغ فقط عند تحميلها
            'reporter' => new UserResource($this->whenLoaded('user')),
            'reported_at' => $this->created_at->diffForHumans(), // تنسيق التاريخ ليكون سهل القراءة
        ];
    }
}
