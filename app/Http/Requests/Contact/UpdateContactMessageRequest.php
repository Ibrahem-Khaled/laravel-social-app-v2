<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactMessageRequest extends FormRequest
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
            'guest_name'  => ['nullable', 'string', 'max:255'],
            'guest_email' => ['nullable', 'email', 'max:255'],
            'guest_phone' => ['nullable', 'string', 'max:30'],

            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string'],

            'status'   => ['required', Rule::in(['open', 'pending', 'closed', 'spam'])],
            'priority' => ['required', Rule::in(['low', 'normal', 'high', 'urgent'])],
            'category' => ['required', Rule::in(['general', 'support', 'sales', 'bug', 'feedback'])],
            'source'   => ['required', Rule::in(['web', 'mobile', 'api'])],

            'attachments.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx,zip', 'max:5120'],
        ];
    }
}
