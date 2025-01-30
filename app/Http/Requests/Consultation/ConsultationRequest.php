<?php

namespace App\Http\Requests\Consultation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
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
        $commonRules = [
            'medico_id' => 'required|integer',
            'paciente_id' => 'required|integer',
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            return array_merge($commonRules, []);
        } else if ($_SERVER['REQUEST_METHOD'] == "PATCH" || $_SERVER['REQUEST_METHOD'] == "PUT") {
            return array_merge($commonRules, []);
        } else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
            return [
                'ids' => 'required|string|min:36',
            ];
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            return [
                'field_filter' => 'nullable|string|in:date,created_at',
                'value_filter' => 'nullable|string|max:255',
                'per_page' => 'nullable|integer|min:1|max:100',
                'sort_by' => 'nullable|string|in:date,doctor_id,patient_id,created_at',
                'sort_order' => 'nullable|string|in:asc,desc',
            ];
        }
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
