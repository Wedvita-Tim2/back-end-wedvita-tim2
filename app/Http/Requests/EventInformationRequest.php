<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator; 
use Illuminate\Http\Exceptions\HttpResponseException;

class EventInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bride_name' => 'required',
            'groom_name' => 'required',
            'bride_father_name' => 'required',
            'bride_mother_name' => 'required',
            'groom_father_name' => 'required',
            'groom_mother_name' => 'required',
            'cover_image' => 'required|image|mimes:jpeg,jpg,png,webp',
            'date_event' => 'required',
            'guests' => 'required',
            'account_number' => 'required|numeric',
            'account_holder_name' => 'required',
            'quotes' => 'sometimes',
            'address' => 'required',
            'building_name' => 'required',
            'lat' => 'sometimes',
            'lng' => 'sometimes',
            'maps_url' => 'sometimes',
            'attachment_name' => 'array|required',
            'attachment_name.*' => 'required|image|mimes:jpeg,jpg,png,webp',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validasi gagal '.$validator->errors(),
            'errors' => $validator->errors(), 
            'response' => 422
        ]));
    }
}
