<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100', 'unique:clients'],
            'address_1' => ['required', 'string'],
            'address_2' => ['string'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'zip' => ['required', 'string', 'max:20'],
            'phone_1' => ['required', 'string', 'max:20'],
            'phone_2' => ['string', 'max:20'],

            'user' => ['required'],
            'user.first_name' => ['required', 'string', 'max:50'],
            'user.last_name' => ['required', 'string', 'max:50'],
            'user.email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'user.password' => ['required', 'string', 'min:6', 'confirmed'],
            'user.password_confirmation' => ['required', 'string', 'min:6'],
            'user.phone' => ['required', 'string', 'max:20'],
            'user.profile_uri' => ['string', 'max:255']
        ];
    }
}
