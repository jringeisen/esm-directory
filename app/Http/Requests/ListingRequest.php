<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
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
            'name' => 'required',
            'business_name' => 'required',
            'category' => 'required',
            'city' => 'required',
            'state' => 'required|max:2',
            'description' => 'required',
            'avatar' => 'required|image|max:1000',
            'starting_package' => 'required'
        ];
    }
}
