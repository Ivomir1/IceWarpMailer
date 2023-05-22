<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
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
        return [  /*          
            'delayed_send' => 'required|date_format:Y-m-d',
            'email' => 'required|array',
            'email.*' => 'email',
            'bcc' => 'array', 
            'bcc.*' => 'email',
            'date' => 'required|date_format:Y-m-d',           
            'label' => 'url',*/
           // 'id' => 'required'
        ];
    }
}
