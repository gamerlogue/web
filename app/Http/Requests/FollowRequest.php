<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Exceptions\ApiDomainException;
use App\Models\User;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class FollowRequest extends FormRequest
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
            'data.attributes.followable_id' => [
                'required',
                'uuid',
                'exists:users,id',
                Rule::unique('followables', 'followable_id')->where('user_id', $this->user()?->id),
            ]
        ];
    }

    /**
     * A follow needs a profile the caller may see, other than their own.
     *
     * @return list<Closure(Validator): void>
     */
    public function after(): array
    {
        return [function (Validator $validator): void {
            $followed = $this->isMethod('POST') ? User::find($this->input('data.attributes.followable_id')) : null;
            if ($followed === null || $validator->errors()->isNotEmpty()) {
                return;
            }
            if ($followed->is($this->user())) {
                throw new ApiDomainException(422, 'cannot_follow_self', 'You cannot follow yourself.');
            }
            $followed->ensureProfileVisibleTo($this->user());
        }];
    }

    /**
     * Writes are limited to the caller's own follows by OwnedResourcesExtension.
     */
    public function authorize(): bool
    {
        return $this->user()?->tokenCan('profile') ?? false;
    }
}
