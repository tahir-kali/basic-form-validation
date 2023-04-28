<?php

namespace App\Http\Requests\Form;
use App\Core\Http\Requests\CoreFormRequest;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Rules\ImageUploadRule;
use App\Rules\InputBooleanRule;
use App\Rules\LocationRule;
use App\Rules\VINRule;
class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;

    public function rules()
    {
        return [
            'fields.1'   => ['required', 'integer', 'max:100'],
            'fields.2'   => ['required', new ImageUploadRule],
            'fields.2.*' => ['nullable', 'file', 'mimes:jpg,bmp,png'],
            'fields.3'   => ['required', new VINRule],
            'fields.4'   => ['required', 'integer', 'max:100'],
            'fields.5'   => ['required', 'integer'],
            'fields.6'   => ['required', 'integer', 'max:100'],
            'fields.7'   => ['required', 'integer'],
            'fields.8'   => ['required', 'array','min:1'],
            'fields.8.*' => [new InputBooleanRule],
            'fields.9'   => ['required', 'string', 'max:255'],
            'fields.10'  => ['required', new LocationRule],
            'fields.11'  => ['required', 'integer', 'max:100'],
        ];
    }

    public function messages()
    {
        return [
            'fields.1.required' => "This field is required and must be an integer",
            'fields.2.required' => "Please make sure to upload at least one image",
            'fields.2.*.mimes'  => "Please only upload images",
            'fields.3.required' => "Please enter your VIN number because it is required",
            'fields.4.required' => 'The value for this field is required.',
            'fields.4.integer'  => 'The value for this field must be an integer.',
            'fields.4.max'      => 'The value for this field cannot be greater than :max.',
            'fields.5.required' => 'The value for this field is required.',
            'fields.5.integer'  => 'The value for this field must be an integer.',
            'fields.6.required' => 'The value for this field is required.',
            'fields.6.integer'  => 'The value for this field must be an integer.',
            'fields.6.max'      => 'The value for this field cannot be greater than :max.',
            'fields.7.required' => 'The value for this field is required.',
            'fields.7.integer'  => 'The value for this field must be an integer.',
            'fields.8.required' => 'The value for this field is required.',
            'fields.9.required' => 'The value for this field is required.',
            'fields.9.max'      => 'The value for this field cannot be greater than :max.',
            'fields.10.required' => 'The value for this field is required.',
            'fields.11.required' => 'The value for this field is required.',
            'fields.11.integer'  => 'The value for this field must be an integer.',
            'fields.11.max'      => 'The value for this field cannot be greater than :max.',


        ];
    }
}
