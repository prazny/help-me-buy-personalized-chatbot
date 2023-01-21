<?php

namespace App\Http\Requests;

use App\enums\FileSourceExtensionEnum;
use App\enums\FileSourceTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreFileSourceRequest extends FormRequest
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
            'name' => 'string|required|min:3|max:50',
            'path' => 'string|min:3|max:400|url|required_if:type,url',
            //'extension' =>  new Enum(FileSourceExtensionEnum::class),
            'type' =>  new Enum(FileSourceTypeEnum::class),
        ];
    }
}
