<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * This method defines the structure of the JSON response for a Wallet object.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Basic wallet information, always included.
            'id' => $this->id,
            'wallet_name' => $this->wallet_name,
            'wallet_type' => $this->wallet_type,
            'is_default' => $this->is_default,

            // A boolean flag to indicate if this specific wallet has its own password.
            // This is useful for the frontend to know if it should ask for a password.
            'has_password' => !is_null($this->password),

            // The encrypted wallet details. We only include this field
            // when the user is requesting a single, specific wallet.
            // This prevents leaking all wallet details in a list view.
            'wallet_details' => $this->when(
                $request->routeIs('financial.showWallet'), // The name of the route to show one wallet
                $this->wallet_details // The decrypted details (Laravel handles decryption automatically)
            ),

            // Timestamps, formatted for consistency.
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
