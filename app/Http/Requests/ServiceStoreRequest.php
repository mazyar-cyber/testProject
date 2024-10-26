<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
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
            'pic' => 'required|image|max:2000',
        ];

    }


    public function messages(): array
    {

        return [
            'pic.max' => 'حجم عکس بیشتر از 2 مگ نمیتواند باشد',
        ];
    }

}
