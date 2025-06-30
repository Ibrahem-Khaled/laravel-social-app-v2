<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // related_type يجب أن يكون نوع موديل صالح يمكن الإبلاغ عنه
            'related_type' => ['required', 'string', Rule::in(['user', 'post', 'comment', 'conversation'])], // أضف أنواع الموديلات التي تسمح بها

            // related_id يجب أن يكون موجودًا في الجدول الموافق للنوع
            'related_id'   => ['required', 'integer', Rule::exists($this->getTableName(), 'id')],

            'reason'       => ['required', 'string', 'max:255'],
            'details'      => ['nullable', 'string', 'max:2000'],
        ];
    }

    protected function getTableName(): string
    {
        // تحويل 'post' -> 'posts', 'user' -> 'users'
        return \Illuminate\Support\Str::plural($this->input('related_type'));
    }

    /**
     * دمج معرّف المستخدم الحالي مع بيانات الطلب.
     */
    protected function passedValidation()
    {
        $this->merge([
            'user_id' => auth()->guard('api')->id(),
        ]);
    }
}
