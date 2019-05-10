<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFrontUpdateRequest extends FormRequest
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
            'name' => "required|regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u|string|max:255",
            'password' => ['string', 'min:5', 'max:10', 'confirmed'],
            'avatar_file' => 'image|mimes:jpg,jpeg,png,gif',
            'cover_image' => 'image|mimes:jpg,jpeg,png,gif',
        ];
    }
}
