<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Traits\DenormalizesIris;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    use DenormalizesIris;

    /**
     * @return array<string, mixed>
     */
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
        if ($this->user()?->tokenCan('profile') !== true) {
            return false;
        }

        // No route id means the collection, which OwnedResourcesExtension narrows to the caller.
        // Item operations still have to name the caller's own id.
        return $this->route('id') === null || $this->user()->id === $this->route('id');
    }

    protected function prepareForValidation(): void
    {
        $this->denormalizeIris();
    }
}
