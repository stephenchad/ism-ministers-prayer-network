<?php

namespace App\Http\Requests\Group;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreGroupRuleRequest extends FormRequest
{
      /**
       * Determine if the user is authorized to make this request.
       */
      public function authorize(): bool
      {
            $group = Group::find($this->input('group_id'));

            if (!$group) {
                  return false;
            }

            return Gate::allows('manageSettings', $group);
      }

      /**
       * Get the validation rules that apply to the request.
       *
       * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
       */
      public function rules(): array
      {
            return [
                  'group_id' => 'required|exists:groups,id',
                  'rule' => 'required|string|max:255',
            ];
      }
}
