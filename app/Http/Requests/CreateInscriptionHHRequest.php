<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInscriptionHHRequest extends FormRequest
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
            'firstname' => 'string|required',
            'lastname' => 'string|required',
            'hh_id' => 'integer|exists:happy_hours,id',
            'filiere' => 'string|required',
            'email' => 'email|required|regex:/^[A-Za-z0-9._%+-]+@cpe.fr$/i'
        ];
    }
}
