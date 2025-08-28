<?php

namespace App\Http\Requests\Api\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'     => ['nullable', 'exists:users,id'],
            'guest_name'  => ['nullable', 'string', 'max:255'],
            'guest_email' => ['nullable', 'email', 'max:255'],
            'guest_phone' => ['nullable', 'string', 'max:30'],

            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string'],

            'status'   => ['nullable', Rule::in(['open', 'pending', 'closed', 'spam'])],
            'priority' => ['nullable', Rule::in(['low', 'normal', 'high', 'urgent'])],
            'category' => ['nullable', Rule::in(['general', 'support', 'sales', 'bug', 'feedback'])],
            'source'   => ['nullable', Rule::in(['web', 'mobile', 'api'])],

            'attachments.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx,zip', 'max:5120'],
        ];
    }
}
