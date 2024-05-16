<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
            'status' => ['string', Rule::in(['open', 'in_progress', 'completed'])],
            'priority' => ['string', Rule::in(['low', 'medium', 'high'])],
            'due_at' => ['date'],
        ];
    }
}
