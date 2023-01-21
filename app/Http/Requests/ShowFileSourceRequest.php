<?php

namespace App\Http\Requests;

use App\Models\FileSource;
use Illuminate\Foundation\Http\FormRequest;

class ShowFileSourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->id == FileSource::findOrFail($this->route('fileSource'))->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
