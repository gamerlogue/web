<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Visibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameListRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'data.attributes.name' => [Rule::requiredIf($this->isMethod('POST')), 'string', 'max:100'],
            'data.attributes.description' => ['sometimes', 'nullable', 'string', 'max:5000'],
            'data.attributes.visibility' => ['sometimes', Rule::enum(Visibility::class)],
            'data.attributes.is_ranked' => ['sometimes', 'boolean:strict'],
            'data.relationships' => ['missing'],
        ];
    }

    /**
     * Ownership on writes and visibility on reads are enforced by OwnedResourcesExtension.
     */
    public function authorize(): bool
    {
        return $this->user()?->tokenCan('library') ?? false;
    }
}
