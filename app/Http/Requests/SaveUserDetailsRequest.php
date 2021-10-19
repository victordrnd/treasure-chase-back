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
            'poids' => 'sometimes|integer',
            'taille' => 'sometimes|integer',
            'pointure' => 'sometimes|integer',
            'is_surf' => 'sometimes|boolean'
        ];
    }
}
