<?php

namespace App\Http\Requests;

use App\Rules\CpfValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
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
        $member_id = $this->route('member_id');
        return [
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('members','email')->ignore($member_id)],
            'phone' => 'sometimes|string|digits_between:8,15|regex:/^\d+$/',
            'cpf' => ['sometimes', 'string', new CpfValidation, 'max:11', Rule::unique('members','cpf')->ignore($member_id)],
            'weight' => 'nullable|numeric|min:10|max:350',
            'height' => 'nullable|numeric|min:0.5|max:2.5',
            'gender' => 'nullable|in:male,female,other',
            'birthday' => 'nullable|date|before:today|after:-100 years|date_format:Y-m-d',
            'start_date' => 'nullable|date|date_format:Y-m-d',
            'status' => 'sometimes|in:active,inactive,suspended',
        ];
    }
}
