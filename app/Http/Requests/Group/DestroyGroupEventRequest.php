<?php

namespace App\Http\Requests\Group;

use App\Models\GroupEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyGroupEventRequest extends FormRequest
{
      /**
       * Determine if the user is authorized to make this request.
       */
      public function authorize(): bool
      {
            $event = $this->route('event');

            if (!$event) {
                  return false;
            }

            return Gate::allows('manageSettings', $event->group);
      }

      /**
       * Get the validation rules that apply to the request.
       */
      public function rules(): array
      {
            return [];
      }
}
