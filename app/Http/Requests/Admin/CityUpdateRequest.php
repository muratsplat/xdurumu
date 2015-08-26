<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

/**
 * The request of updating city model for admin user
 *  
 */
class CityUpdateRequest extends Request
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
            
            'name'      => 'required|min:3',
            'slug'      => 'required|unique:cities,slug',
            'enable'    => 'boolean',
            'priority'  => 'numeric|digits_between:1,3',
        ];
    }
}
