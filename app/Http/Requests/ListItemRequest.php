<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListItemRequest extends FormRequest
{
    /**
     * The list and the game are fixed once the item exists: moving a game is a delete and a create.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $creating = $this->isMethod('POST');

        return [
            'data.attributes.list_id' => [
                Rule::requiredIf($creating),
                Rule::prohibitedIf(! $creating),
                'integer:strict',
                // Someone else's list does not exist as far as the caller is concerned.
                Rule::exists('game_lists', 'id')->where('user_id', $this->user()?->id),
            ],
            'data.attributes.game_id' => [
                Rule::requiredIf($creating),
                Rule::prohibitedIf(! $creating),
                'integer:strict',
                'min:1',
                Rule::unique('list_items', 'game_id')->where('list_id', $this->input('data.attributes.list_id')),
            ],
            'data.attributes.position' => ['sometimes', 'integer:strict', 'min:0'],
            'data.attributes.note' => ['sometimes', 'nullable', 'string', 'max:2000']
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
