<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ReportReason;
use App\Models\Report;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if (! $this->isMethod('POST')) {
            return [];
        }
        $type = $this->input('data.attributes.reportable_type');

        return [
            'data.attributes.reportable_type' => ['required', Rule::in(array_keys(Report::REPORTABLE_TYPES))],
            'data.attributes.reportable_id' => [
                'required',
                'string',
                'max:64',
                function (string $attribute, mixed $value, Closure $fail) use ($type): void {
                    $model = Report::REPORTABLE_TYPES[$type] ?? null;
                    if ($model !== null && ! $model::whereKey($value)->exists()) {
                        $fail(__('validation.exists', ['attribute' => 'reportable_id']));
                    }
                },
                // One report per subject: a second one would only repeat the first.
                Rule::unique('reports', 'reportable_id')->where('user_id', $this->user()?->id)->where('reportable_type', $type),
            ],
            'data.attributes.reason' => ['required', Rule::enum(ReportReason::class)],
            'data.attributes.note' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Blocks do not stop a report: blocking an abuser and reporting them go together.
     */
    public function authorize(): bool
    {
        return $this->user()?->tokenCan('profile') ?? false;
    }
}
