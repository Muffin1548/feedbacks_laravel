<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbacksFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|unique:posts|max:255',
            'title' => array('Regex:/^[A-Za-zА-Яа-я0-9 ]+$/'),
            'text' => 'required',
        ];
    }
}
