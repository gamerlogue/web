<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Traits\DenormalizesIris;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    use DenormalizesIris;

    public function rules(): array
    {
        return [
            'data.attributes.first_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'data.attributes.last_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'data.attributes.nickname' => ['sometimes', 'nullable', 'string', 'max:255'],
            'data.attributes.picture' => ['sometimes', 'nullable', 'string', 'max:2048'],
        ];
    }

    public function authorize(): bool
    {
        // Users may only patch their own resource.
        return $this->user()?->id === $this->route('id');
    }
}
