<?php

namespace App\Http\Requests\Api\Internal\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
                'base_url' => 'required|url',
                'name' => 'required|string|unique:services',
            ]);
        } elseif (in_array($this->method(), ['PUT', 'PATCH'])) {
            return array_merge($baseRules, [
                'base_url' => 'url',
                'name' => [
                    'string',
                    Rule::unique('services', 'name')->ignore($this->getNameId(), 'name'),
                ],
            ]);
        }

        return $baseRules;
    }

    public function getNameId(): string
    {
        return (string) $this->route('service');
    }

    public function getName(): ?string
    {
        return $this->get('name');
    }

    public function getServiceBaseUrl(): ?string
    {
        return $this->get('base_url');
    }
}
