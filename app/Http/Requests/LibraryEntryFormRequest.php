<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\LibraryEntryCompletionStatus;
use App\Enums\LibraryEntryStatus;
use App\Traits\DenormalizesIris;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class LibraryEntryFormRequest extends FormRequest
{
    use DenormalizesIris;

    public function rules(): array
    {
        return [
            'data.attributes.user_id' => [
                Rule::requiredIf($this->isMethod('POST')),
                Rule::prohibitedIf(! $this->isMethod('POST')),
                'uuid',
                'exists:users,id',
            ],
            'data.attributes.game_id' => [Rule::requiredIf($this->isMethod('POST')), 'integer'],
            'data.attributes.status' => [Rule::requiredIf($this->isMethod('POST')), Rule::enum(LibraryEntryStatus::class)],
            'data.attributes.completion_status' => ['nullable', Rule::enum(LibraryEntryCompletionStatus::class)],
            'data.attributes.owned' => ['boolean'],
            'data.attributes.editions_ids' => ['nullable', 'array'],
            'data.attributes.editions_ids.*' => ['integer'],
            'data.attributes.platforms_ids' => ['nullable', 'array'],
            'data.attributes.platforms_ids.*' => ['integer'],
            'data.attributes.start_date' => ['nullable', 'date'],
            'data.attributes.end_date' => ['nullable', 'date', 'after_or_equal:data.attributes.start_date'],
            'data.attributes.played_time' => ['nullable', 'integer', 'min:0'],
            'data.attributes.rating' => ['nullable', 'numeric:strict', 'between:0,100'],
            'data.attributes.rating_details' => ['nullable', 'array'],
            'data.attributes.review' => ['nullable', 'string'],
            'data.relationships.user' => [Rule::prohibitedIf(! $this->isMethod('POST'))],
        ];
    }

    /**
     * Ownership on writes is enforced by OwnedLibraryEntriesExtension, which scopes every item
     * query to the authenticated user: someone else's entry is already a 404 before we get here.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->denormalizeIris();

        if ($this->isMethod('POST')) {
            $data = $this->all();
            Arr::set($data, 'data.attributes.user_id', $this->user()->id);
            Arr::forget($data, 'data.relationships.user');
            $this->replace($data);
        }
    }
}
