<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TombolaTicketRequest extends FormRequest
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
            'email' => 'email|required',
            'adresse' => 'string|required',
            'filiere' => 'string|required|in:3CGP,3ETI,3IRC,3ICS,3GPI,4CGP,4ETI,4IRC,4ICS,4GPI,5CGP,5ETI,5IRC',
            'count' => 'integer|required|min:1|max:30'
        ];
    }
}
