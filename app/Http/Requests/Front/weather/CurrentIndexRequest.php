<?php

namespace App\Http\Requests\Front\Weather;

use App\Http\Requests\Request;

/**
 * The request of updating city model for admin user
 *  
 */
class CurrentIndexRequest extends Request
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
            
            'mode'      => 'required|in:random',
            'cnt'       => 'required|numeric|between:1,100',            
        ];
    }
}
