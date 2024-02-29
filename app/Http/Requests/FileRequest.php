<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required|file|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Выберите файл для загрузки.',
            'file.file' => 'Загружаемый файл должен быть файлом.',
            'file.max' => 'Размер файла не должен превышать 2MB.',
        ];
    }
}
