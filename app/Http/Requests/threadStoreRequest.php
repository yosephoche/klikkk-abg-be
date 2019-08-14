<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class threadStoreRequest extends FormRequest
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
            'category_id' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'images.*' => 'mimes:jpeg,bmp,png,jpg',
            'videos.*' => 'mimetypes:video/avi,video/mpeg,video/quicktime',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_.required' => 'Pick One Category',
            'subject.required'  => 'What Is The Subject Of The Thread',
            'description.required' => 'Please give description to this thread',
            'images.mimes' => 'This Type Of File Is Not Supported',
            'video.mimetypes' => 'This Type Of File Is Not Supported',
        ];
    }
}
