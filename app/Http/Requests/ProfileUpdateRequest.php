<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $profileId = optional($this->user()->profile)->id ?? null;

        return [
            // Username is optional (Breeze submits only name/email). If provided, validate & keep unique.
            'username' => ['sometimes', 'nullable', 'alpha_dash', 'min:3', 'max:50', Rule::unique('profiles', 'username')->ignore($profileId)],

            'display_name' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', 'max:2048'],

            // Breeze expectations
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255'],
        ];
    }
}
