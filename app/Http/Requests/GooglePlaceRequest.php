<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GooglePlaceRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'search' => 'required|string|max:50',
            'location' => 'required|string|max:50',
        ];
    }
    
}