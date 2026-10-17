<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Comment;
use App\Models\Reaction;
use App\Traits\ResolvesInteractionTarget;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ReactionRequest extends FormRequest
{
    use ResolvesInteractionTarget;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $creating = $this->isMethod('POST');
        if (! $creating && ! $this->isMethod('PATCH')) {
            return [];
        }

        return [
            'data.attributes.reactable_type' => [Rule::requiredIf($creating), Rule::prohibitedIf(! $creating), Rule::in(self::INTERACTION_TYPES)],
            'data.attributes.reactable_id' => [
                Rule::requiredIf($creating),
                Rule::prohibitedIf(! $creating),
                'integer:strict',
                'min:1',
                // One reaction per subject: changing it is a PATCH.
                Rule::unique('reactions', 'reactable_id')->where('user_id', $this->user()?->id)->where('reactable_type', $this->input('data.attributes.reactable_type')),
            ],
            'data.attributes.type' => ['required', 'string', 'max:32'],
            'data.relationships' => ['missing'],
        ];
    }

    /**
     * Reviews and lists only take a like; comments take a like or any single emoji.
     *
     * @return list<Closure(Validator): void>
     */
    public function after(): array
    {
        return [function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }
            $target = $this->isMethod('POST')
                ? $this->interactionTarget('data.attributes.reactable_type', 'data.attributes.reactable_id')
                : Reaction::find($this->route('id'))?->reactable;
            if ($target === null) {
                $validator->errors()->add('data.attributes.reactable_id', __('validation.exists', ['attribute' => 'reactable_id']));

                return;
            }

            $type = (string) $this->input('data.attributes.type');
            $emoji = preg_match('/^\X$/u', $type) === 1 && preg_match('/\p{Extended_Pictographic}|\p{Regional_Indicator}|\x{20E3}/u', $type) === 1;
            if ($type !== Reaction::LIKE && ! ($target instanceof Comment && $emoji)) {
                $validator->errors()->add('data.attributes.type', 'Use "like", or a single emoji on a comment.');
            }
        }];
    }

    /**
     * Writes are limited to the caller's own reactions by OwnedResourcesExtension.
     */
    public function authorize(): bool
    {
        return $this->user()?->tokenCan('profile') ?? false;
    }
}
