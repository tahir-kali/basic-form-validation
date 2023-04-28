<?php

namespace App\Http\Requests\Form;

use App\Core\Http\Requests\CoreFormRequest;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Models\Form;
use App\Rules\ImageUploadRule;
use App\Rules\InputBooleanRule;
use App\Rules\LocationRule;
use App\Rules\VINRule;

class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;

    public function rules(): array
    {
        $rules_array   = [];
        $validationArr = $this->articulateValidations();
        foreach ($validationArr as $field) {
            $ftv          = $field;
            $fid          = 'fields.' . $ftv['id'];
            if (count($ftv['validations'])) {
                $rule = [$ftv['validations'][0], $ftv['data_type'], ...array_slice($ftv["validations"], 1)];
            } else {
                $rule = ['nullable', $ftv['data_type']];
            }
            $rules_array[$fid] = $rule;
        }
        return $rules_array;
//        return [
//            'fields.1'   => ['required', 'integer', 'max:100'],
//            'fields.2'   => ['required', new ImageUploadRule],
//            'fields.2.*' => ['nullable', 'file', 'mimes:jpg,bmp,png'],
//            'fields.3'   => ['required', new VINRule],
//            'fields.4'   => ['required', 'integer', 'max:100'],
//            'fields.5'   => ['required', 'integer'],
//            'fields.6'   => ['required', 'integer', 'max:100'],
//            'fields.7'   => ['required', 'integer'],
//            'fields.8'   => ['required', 'array', 'min:1'],
//            'fields.8.*' => [new InputBooleanRule],
//            'fields.9'   => ['required', 'string', 'max:255'],
//            'fields.10'  => ['required', new LocationRule],
//            'fields.11'  => ['required', 'integer', 'max:100'],
//        ];
    }

    public function validateFieldMetaData($field)
    {
        if (!isset($field['id']) || !isset($field['data_type']) || !isset($field["validation"])) {
            trigger_error("Invalide field", E_USER_ERROR);
        }
    }

    public function articulateValidations()
    {
        $field_meta_data   = Form::FIELDS['data']['fields'];
        $field_validations = [];
        foreach ($field_meta_data as $field) {
            $this->validateFieldMetaData($field);
            $temp_field_obj                = [
                "id"        => $field["id"],
                "data_type" => $field["data_type"],
            ];
            $temp_field_obj["validations"] = $this->extractValidationRules($field["validation"]);
            $temp_field_obj["messages"]    = $this->extractValidationMessages($field['validation']);
            if (isset($field['values']) && count($field['values'])) {
                $temp_field_obj['values'] = $this->extractFieldValuesIntoArray($field['values']);
            }
            array_push($field_validations, $temp_field_obj);
        }

        return $field_validations;
    }

    public function extractValidationRules($validation)
    {
        $validation_arr = [];
        foreach ($validation as $validation) {
            $rule = $validation['rule']; // required, min, max
            if ($rule == "number") {
               continue;
            }
            $params           = $validation['params'];
            $validationString = $rule;
            if (count($params)) {
                $validationString .= "|" . implode(",", $params);
            }
            array_push($validation_arr, $validationString);
        }

        return $validation_arr;
    }

    public function extractValidationMessages($validation)
    {
        $messages = [];
        foreach ($validation as $validation) {
            $rule = $validation['rule']; // required, min, max
            if ($rule == "number") {
                $rule = "integer";
            }
            $validationObj                    = [];
            $validationObj[$rule] = $validation["message"];
            array_push($messages, $validationObj);
        }

        return $messages;
    }

    public function extractFieldValuesIntoArray($values)
    {
        $valueArr = [];
        foreach ($values as $val) {
            array_push($valueArr, $val["value"]);
        }

        return $valueArr;
    }


    function messages()
    {
        $validationArr = $this->articulateValidations();
        $messages = [];
        foreach($validationArr as $field){
            foreach($field['messages'] as $message){

                $messages['fields.'.$field['id'].'.'.key($message)] = current((array)$message);
            }
        }
        return $messages;
//        return [
//            'fields.1.required'  => "This field is required and must be an integer",
//            'fields.2.required'  => "Please make sure to upload at least one image",
//            'fields.2.*.mimes'   => "Please only upload images",
//            'fields.3.required'  => "Please enter your VIN number because it is required",
//            'fields.4.required'  => 'The value for this field is required.',
//            'fields.4.integer'   => 'The value for this field must be an integer.',
//            'fields.4.max'       => 'The value for this field cannot be greater than :max.',
//            'fields.5.required'  => 'The value for this field is required.',
//            'fields.5.integer'   => 'The value for this field must be an integer.',
//            'fields.6.required'  => 'The value for this field is required.',
//            'fields.6.integer'   => 'The value for this field must be an integer.',
//            'fields.6.max'       => 'The value for this field cannot be greater than :max.',
//            'fields.7.required'  => 'The value for this field is required.',
//            'fields.7.integer'   => 'The value for this field must be an integer.',
//            'fields.8.required'  => 'The value for this field is required.',
//            'fields.9.required'  => 'The value for this field is required.',
//            'fields.9.max'       => 'The value for this field cannot be greater than :max.',
//            'fields.10.required' => 'The value for this field is required.',
//            'fields.11.required' => 'The value for this field is required.',
//            'fields.11.integer'  => 'The value for this field must be an integer.',
//            'fields.11.max'      => 'The value for this field cannot be greater than :max.',
//
//
//        ];
    }
}
