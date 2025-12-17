<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can update a profile; controller will perform ownership check via policy.
        return (bool) $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $profileId = optional($this->user()->profile)->id ?? null;

        return [
            'username' => ['required', 'alpha_dash', 'min:3', 'max:50', Rule::unique('profiles', 'username')->ignore($profileId)],
            'display_name' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
