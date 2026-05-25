<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResourceRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'min:5', 'max:255'],
            'category_id'   => ['required', 'exists:categories,id'],
            'description'   => ['required', 'string', 'min:20'],
            'type'          => ['required', 'in:share,request'],
            'status'        => ['required', 'in:active,paused,closed'],
            'location'      => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'attachment_file' => ['nullable', 'file', 'max:10240'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.min'          => 'Title must be at least 5 characters.',
            'description.min'    => 'Description must be at least 20 characters.',
            'attachment_file.max' => 'Attachment must not exceed 10MB.',
        ];
    }
}
