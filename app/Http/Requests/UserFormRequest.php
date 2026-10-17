<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Visibility;
use App\Models\User;
use App\Traits\DenormalizesIris;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
            'data.attributes.nickname' => $this->nicknameRules(),
            'data.attributes.picture' => ['sometimes', 'nullable', 'string', 'max:2048'],
            'data.attributes.bio' => ['sometimes', 'nullable', 'string', 'max:500'],
            'data.attributes.banner_game_id' => ['sometimes', 'nullable', 'integer:strict', 'min:1'],
            'data.attributes.banner_image_id' => ['sometimes', 'nullable', 'string', 'max:255'],
            'data.attributes.platforms_ids' => ['sometimes', 'array', 'list'],
            'data.attributes.platforms_ids.*' => ['integer:strict', 'min:1', 'distinct'],
            'data.attributes.visibility' => ['sometimes', Rule::enum(Visibility::class)],
        ];
    }

    /**
     * The banner is an image of a game: both halves are set or cleared together, also when a PATCH
     * sends only one of them.
     *
     * @return list<Closure(Validator): void>
     */
    public function after(): array
    {
        return [function (Validator $validator): void {
            $attributes = $this->input('data.attributes');
            if (! is_array($attributes) || ! array_intersect_key($attributes, array_flip(['banner_game_id', 'banner_image_id']))) {
                return;
            }

            $game = array_key_exists('banner_game_id', $attributes) ? $attributes['banner_game_id'] : $this->user()?->banner_game_id;
            $image = array_key_exists('banner_image_id', $attributes) ? $attributes['banner_image_id'] : $this->user()?->banner_image_id;
            if (($game === null) !== ($image === null)) {
                $validator->errors()->add('data.attributes.banner_image_id', 'The banner game and image must be set or cleared together.');
            }
        }];
    }

    public function authorize(): bool
    {
        // Any profile is readable; OwnedResourcesExtension limits writes to the caller's own.
        return $this->user()?->tokenCan('profile') === true;
    }

    protected function prepareForValidation(): void
    {
        $this->denormalizeIris();
    }

    /**
     * 3 to 30 letters, digits, `_`, `.` or `-`, unique regardless of case. Nicknames seeded by the
     * identity provider before these rules existed may not comply, so resubmitting the current
     * nickname unchanged is always accepted.
     *
     * @return list<mixed>
     */
    private function nicknameRules(): array
    {
        $nickname = $this->input('data.attributes.nickname');
        if ($nickname !== null && $nickname === $this->user()?->nickname) {
            return [];
        }

        return ['sometimes', 'nullable', 'string', 'min:3', 'max:30', 'regex:/^[\pL\pN_.-]+$/u',
            function (string $attribute, mixed $value, Closure $fail): void {
                if (is_string($value) && User::where('nickname_key', mb_strtolower($value))->whereKeyNot($this->user()?->id)->exists()) {
                    $fail(__('validation.unique', ['attribute' => 'nickname']));
                }
            },
        ];
    }
}
