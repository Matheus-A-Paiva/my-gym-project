<?php

namespace App\Http\Requests;

use App\Rules\CpfValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMemberRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'phone' => 'nullable|string|digits_between:8,15|regex:/^\d+$/',
            'cpf' => ['required', 'string', 'max:11', 'unique:members', new CpfValidation],
            'weight' => 'nullable|numeric|min:10|max:350',
            'height' => 'nullable|numeric|min:0.5|max:2.5',
            'gender' => 'nullable|in:male,female,other',
            'birthday' => 'nullable|date|before:today|after:-100 years|date_format:Y-m-d',
            'start_date' => 'nullable|date|date_format:Y-m-d',
            'status' => 'required|in:active,inactive,suspended',
        ];
    }
}
