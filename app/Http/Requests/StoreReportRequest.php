<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\OutageType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Valide le formulaire public de signalement. Pas d'authorize() : la page est ouverte à tous.
 */
class StoreReportRequest extends FormRequest
{
    /**
     * Retire les espaces du téléphone avant la validation : « 07 08 12 34 56 » devient « 0708123456 ».
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone' => str_replace(' ', '', (string) $this->input('phone')),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(OutageType::class)],
            'neighborhood_id' => ['required', 'integer', 'exists:neighborhoods,id'],
            'description' => ['required', 'string', 'min:5', 'max:500'],
            'phone' => ['required', 'regex:/^0[157][0-9]{8}$/'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Choisissez le type de coupure : eau ou électricité.',
            'neighborhood_id.required' => 'Choisissez votre quartier.',
            'phone.regex' => 'Le téléphone doit contenir 10 chiffres et commencer par 01, 05 ou 07.',
        ];
    }
}
