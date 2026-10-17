<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Marking as read or unread is the only write.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->isMethod('PATCH')
            ? ['data.attributes' => ['required', 'array:is_read'], 'data.attributes.is_read' => ['required', 'boolean:strict']]
            : [];
    }

    /**
     * OwnedResourcesExtension limits everything to the caller's own notifications.
     */
    public function authorize(): bool
    {
        return $this->user()?->tokenCan('profile') ?? false;
    }
}
