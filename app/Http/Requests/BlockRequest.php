<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Exceptions\ApiDomainException;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class BlockRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if (! $this->isMethod('POST')) {
            return [];
        }

        return [
            'data.attributes.blocked_id' => [
                'required',
                'uuid',
                'exists:users,id',
                Rule::unique('user_blocks', 'blocked_id')->where('user_id', $this->user()?->id),
            ]
        ];
    }

    /**
     * @return list<Closure(Validator): void>
     */
    public function after(): array
    {
        return [function (): void {
            if ($this->isMethod('POST') && $this->input('data.attributes.blocked_id') === $this->user()?->id) {
                throw new ApiDomainException(422, 'cannot_block_self', 'You cannot block yourself.');
            }
        }];
    }

    /**
     * Writes are limited to the caller's own blocks by OwnedResourcesExtension.
     */
    public function authorize(): bool
    {
        return $this->user()?->tokenCan('profile') ?? false;
    }
}
