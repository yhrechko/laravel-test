<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetAllAccountsRequest extends FormRequest
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
            'id' => ['nullable', 'integer'],
            'name' => ['nullable', 'string', 'max:100'],
            'address_1' => ['nullable', 'string'],
            'address_2' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'phone_1' => ['nullable', 'string', 'max:20'],
            'phone_2' => ['nullable', 'string', 'max:20'],
            'zip' => ['nullable', 'string', 'max:20'],
            'start_validity' => ['nullable', 'date'],
            'end_validity' => ['nullable', 'date'],
            'status' => ['nullable', 'string', Rule::in('Active', 'Inactive')],
            'created_at' => ['nullable', 'date'],
            'updated_at' => ['nullable', 'date'],

            'order_by' => ['string', Rule::in((new Client())->sortable)],
            'order_direction' => ['string', 'regex:/^(?:asc|desc)$/i']
        ];
    }
}
