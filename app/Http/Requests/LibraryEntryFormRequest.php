<?php

namespace App\Http\Requests;

use App\Models\LibraryEntry;
use App\Traits\DenormalizesIris;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class LibraryEntryFormRequest extends FormRequest
{
    use DenormalizesIris;

    public function rules(): array
    {
        return [
            'data.attributes.user_id' => ['required_without:data.relationships.user', 'exists:users,id'],
            'data.attributes.game_id' => ['required', 'integer'],
            'data.attributes.status' => ['required'],
            'data.attributes.completion_status' => ['nullable'],
            'data.attributes.owned' => ['boolean'],
            'data.attributes.edition_id' => ['nullable', 'integer'],
            'data.attributes.platforms_ids' => ['nullable'],
            'data.attributes.start_date' => ['nullable', 'date'],
            'data.attributes.end_date' => ['nullable', 'date'],
            'data.attributes.played_time' => ['nullable', 'int'],
            'data.attributes.rating' => ['nullable', 'numeric:strict'],
            'data.attributes.rating_details' => ['nullable'],
            'data.attributes.review' => ['nullable', 'string'],
            'data.relationships.user.data.id' => ['required_without:data.attributes.user_id', 'exists:users,id'],
        ];
    }

    public function authorize(): bool
    {
        $resourceUserId = $this->input('data.attributes.user_id') ?? $this->input('data.relationships.user.data.id');
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $entryId = $this->route('id');
            $entry = LibraryEntry::findOrFail($entryId);

            return $this->user()->id === $resourceUserId && $this->user()->id === $entry->user_id;
        }

        // Allow POST only if the user_id matches the authenticated user
        if ($this->method() === 'POST') {
            return $this->user()->id === $resourceUserId;
        }

        return true;
    }

    public function validationData(): array
    {
        $data = parent::validationData();

        $isNew = $this->method() === 'POST';

        if ($isNew) {
            // Set current user id for new entries
            Arr::set($data, 'data.attributes.user_id', $this->user()->id);
        }

        return $data;
    }
}

