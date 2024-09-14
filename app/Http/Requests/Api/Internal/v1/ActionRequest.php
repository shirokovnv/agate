<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Internal\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $baseRules = [];

        if ($this->method() === 'POST') {
            return array_merge($baseRules, [
                'method' => 'required|string',
                'pattern' => 'required|string',
                'priority' => 'integer',
                'workflows' => 'array',
                'name' => 'required|string|unique:actions',
            ]);
        } elseif (in_array($this->method(), ['PATCH', 'PUT'])) {
            return array_merge($baseRules, [
                'method' => 'string',
                'pattern' => 'string',
                'priority' => 'integer',
                'workflows' => 'array',
                'name' => [
                    'string',
                    Rule::unique('actions', 'name')->ignore($this->getNameId(), 'name'),
                ],
            ]);
        }

        return $baseRules;
    }

    public function getNameId(): string
    {
        return (string) $this->route('action');
    }

    public function getActionMethod(): ?string
    {
        return $this->get('method');
    }

    public function getPattern(): ?string
    {
        return $this->get('pattern');
    }

    public function getPriority(): int
    {
        return (int) $this->get('priority');
    }

    public function getName(): ?string
    {
        return $this->get('name');
    }

    public function getWorkflows(): array
    {
        return (array) $this->get('workflows');
    }
}
