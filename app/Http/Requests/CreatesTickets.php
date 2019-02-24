<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatesTickets extends FormRequest
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
            'priority'  => ['required', 'integer'],
            'category'  => ['required', 'integer'],
            'subject'   => ['required', 'string', 'max:255'],
            'body'      => ['required', 'string', 'max:5000'],
        ];
    }
}
