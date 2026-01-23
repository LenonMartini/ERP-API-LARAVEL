<?php

namespace App\Http\Requests\Me;

use Illuminate\Foundation\Http\FormRequest;

class MeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // garante que existe usuário autenticado
        return auth()->check();
    }

    protected function failedAuthorization()
    {
        throw new AuthenticationException('Unauthenticated user.');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
