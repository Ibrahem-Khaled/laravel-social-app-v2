<?php

namespace App\Http\Requests\Api\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    } // ضع Policy لاحقًا

    public function rules(): array
    {
        return [
            'status'   => ['sometimes', 'required', Rule::in(['open', 'pending', 'closed', 'spam'])],
            'priority' => ['sometimes', 'required', Rule::in(['low', 'normal', 'high', 'urgent'])],
            'category' => ['sometimes', 'required', Rule::in(['general', 'support', 'sales', 'bug', 'feedback'])],
            'assignee_id' => ['sometimes', 'nullable', 'exists:users,id'],
            'replied_at'  => ['sometimes', 'nullable', 'date'],
        ];
    }
}
