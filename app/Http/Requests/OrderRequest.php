<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'location'      => 'required',
            'region'        => 'required',
            'city'          => 'required',
            'ghana_post'    => 'required',
            'phonenumber'   => 'required',
            'notes'         => 'nullable',
            'firstname'     => 'required',
            'amount'        => 'required',
            'email'         =>  'required',
        ];
    }
}
