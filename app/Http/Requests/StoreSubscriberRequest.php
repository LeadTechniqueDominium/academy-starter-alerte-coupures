<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Valide l'inscription aux alertes d'un quartier.
 */
class StoreSubscriberRequest extends FormRequest
{
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
            'phone' => [
                'required',
                'regex:/^0[157][0-9]{8}$/',
                // Un même numéro ne s'abonne qu'une fois à un même quartier.
                Rule::unique('subscribers', 'phone')->where('neighborhood_id', $this->input('neighborhood_id')),
            ],
            'neighborhood_id' => ['required', 'integer', 'exists:neighborhoods,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Le téléphone doit contenir 10 chiffres et commencer par 01, 05 ou 07.',
            'phone.unique' => 'Ce numéro est déjà abonné aux alertes de ce quartier.',
            'neighborhood_id.required' => 'Choisissez votre quartier.',
        ];
    }
}
