<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'poids' => 'sometimes|integer|nullable',
            'taille' => 'sometimes|integer|nullable',
            'pointure' => 'sometimes|numeric|nullable',
            'is_surf' => 'sometimes|boolean'
        ];
    }
}
