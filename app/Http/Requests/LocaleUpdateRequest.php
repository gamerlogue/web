<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use LaravelLang\Locales\Facades\Locales;

class LocaleUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'locale' => [
                'required',
                'string',
                static function (string $attribute, mixed $value, Closure $fail): void {
                    if (! Locales::isAvailable($value)) {
                        $fail('The selected locale is not available.');
                    }
                },
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
