<?php

namespace App\Http\Requests\Group;

use App\Models\GroupEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateGroupEventRequest extends FormRequest
{
      /**
       * Determine if the user is authorized to make this request.
       */
      public function authorize(): bool
      {
            // The route model binding will resolve the event.
            $event = $this->route('event');

            if (!$event) {
                  return false;
            }

            return Gate::allows('manageSettings', $event->group);
      }

      /**
       * Get the validation rules that apply to the request.
       *
       * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
       */
      public function rules(): array
      {
            return [
                  'title' => 'required|string|max:255',
                  'description' => 'nullable|string',
                  'event_date' => 'required|date',
                  'location' => 'nullable|string|max:255',
            ];
      }
}
