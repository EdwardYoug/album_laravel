<?php

namespace App\Http\Requests\Album;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlbum extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /*
     * Тут необходимо проверить авторизован ли текущий user, а не просто вернуть true
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
            'title' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public function messages() {
        return [
            'title.required' => 'Это поле не должно быть пустым',
            'title.string' => 'Это поле должно быть строкой',
            'description.required' => 'Это поле не должно быть пустым',
            'description.string' => 'Это поле должно быть строкой',
        ];
    }
}
