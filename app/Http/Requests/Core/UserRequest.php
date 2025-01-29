<?php

namespace App\Http\Requests\Core;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * @var Validator|null
     */
    public $validator;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $commonRules = [];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            return array_merge($commonRules, [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
                'email' => 'required|email|unique:users,email',
            ]);
        } else if ($_SERVER['REQUEST_METHOD'] == "PATCH" || $_SERVER['REQUEST_METHOD'] == "PUT") {
            return array_merge($commonRules, [
                'name' => 'nullable|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
                'email' => 'nullable|string|email|unique:users,email,'.$this->id,
            ]);
        } else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            return [
                'ids' => 'required|string|min:36',
            ];
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            return [
                'field_filter' => 'nullable|string|in:first_name,last_name,email,created_at',
                'value_filter' => 'nullable|string|max:255',
                'per_page' => 'nullable|integer|min:1|max:100',
                'sort_by' => 'nullable|string|in:first_name,last_name,email,created_at',
                'sort_order' => 'nullable|string|in:asc,desc',
            ];
        }

        return [];
    }

    public function messages(): array
    {
        return [];
    }

    protected function failedValidation(Validator $validator): void
    {
        $this->validator = $validator;
    }
}
