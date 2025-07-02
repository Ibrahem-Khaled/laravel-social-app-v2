<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalRequestResource extends JsonResource
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
            'amount' => (float) $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'rejection_reason' => $this->when($this->status === 'rejected', $this->rejection_reason),

            // Timestamps
            'requested_at' => $this->created_at->toDateTimeString(),
            'processed_at' => optional($this->processed_at)->toDateTimeString(),

            // Related Data (loaded conditionally for performance)
            // The 'user' object will only be included if it was eager-loaded with 'with()' in the controller.
            'user' => new UserResource($this->whenLoaded('user')),

            // The 'wallet' object will only be included if it was eager-loaded.
            'wallet' => new WalletResource($this->whenLoaded('wallet')),
        ];
    }
}
