<?php

namespace App\Http\Requests\Group;

use App\Models\GroupResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyGroupResourceRequest extends FormRequest
{
      /**
       * Determine if the user is authorized to make this request.
       */
      public function authorize(): bool
      {
            $resource = $this->route('resource');

            if (!$resource) {
                  return false;
            }

            return Gate::allows('manageSettings', $resource->group);
      }

      /**
       * Get the validation rules that apply to the request.
       */
      public function rules(): array
      {
            return [];
      }
}
