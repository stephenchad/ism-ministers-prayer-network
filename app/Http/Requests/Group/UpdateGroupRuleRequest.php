<?php

namespace App\Http\Requests\Group;

use App\Models\GroupRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateGroupRuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $rule = GroupRule::find($this->route('rule'));

        if (!$rule) {
            return false;
        }

        return Gate::allows('manageSettings', $rule->group);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rule' => 'required|string|max:255',
        ];
    }
}
