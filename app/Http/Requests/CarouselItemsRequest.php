<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarouselItemsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'carousel_name'     => 'string|max:255',
            'image_path'        => 'required|image|mimes:jpg,gif,png,bmp|max:5120',
            'description'       => 'string|nullable|max:255',
            'user_id'           => 'required|integer',
        ];
    }
}
