<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Comment;
use App\Traits\ResolvesInteractionTarget;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CommentRequest extends FormRequest
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
            'data.attributes.commentable_type' => [Rule::requiredIf($creating), Rule::prohibitedIf(! $creating), Rule::in(self::INTERACTION_TYPES)],
            'data.attributes.commentable_id' => [Rule::requiredIf($creating), Rule::prohibitedIf(! $creating), 'integer:strict', 'min:1'],
            'data.attributes.comment' => [Rule::requiredIf($creating), 'string', 'max:2000'],
            'data.attributes.spoiler' => ['sometimes', 'boolean:strict'],
            'data.relationships' => ['missing'],
        ];
    }

    /**
     * @return list<Closure(Validator): void>
     */
    public function after(): array
    {
        return [function (Validator $validator): void {
            if ($this->isMethod('POST') && $validator->errors()->isEmpty()
                && $this->interactionTarget('data.attributes.commentable_type', 'data.attributes.commentable_id') === null) {
                $validator->errors()->add('data.attributes.commentable_id', __('validation.exists', ['attribute' => 'commentable_id']));
            }
        }];
    }

    /**
     * Editing is limited to the author by OwnedResourcesExtension. Deleting is also open to the
     * owner of the review or list at the top of the thread, hence the policy.
     */
    public function authorize(): bool
    {
        if ($this->user()?->tokenCan('profile') !== true) {
            return false;
        }
        if ($this->isMethod('DELETE')) {
            return Gate::allows('delete', Comment::findOrFail($this->route('id')));
        }

        return true;
    }
}
