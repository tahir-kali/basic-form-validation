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
            $fid = 'fields.' . $field['id'];
            if (count($field['validations'])) {
                $rule = [$field['validations'][0], $field['data_type'], ...array_slice($field["validations"], 1)];
            } else {
                $rule = ['nullable', $field['data_type']];
            }
            //Add extra parent validations to rule array
            if (isset($field['parent_validations']) && count($field['parent_validations'])) {
                foreach ($field['parent_validations'] as $key => $value) {
                    array_push($rule, "$key:$value");
                }
            }
//            Add custom validations start
            if ($field['slug'] === 'location') {
                array_push($rule, new LocationRule);
            }
            if ($field['slug'] === 'images') {
                array_push($rule, new ImageUploadRule);
            }
            if ($field['slug'] === 'VIN') {
                array_push($rule, new VINRule);
            }
//            Add custom validations end
            if ($field['data_type'] !== 'array' && isset($field['values']) && count($field['values']) > 0) {
                array_push($rule, 'in:' . implode(',', $field['values']));
            }
            if ($field['data_type'] === 'array') {
                $children_validataions_array = [
                    count($field['validations']) > 0 ? $field['validations'][0] : 'nullable',
                ];
                if (isset($field['values']) && count($field['values'])) {
                    $children_validataions_array = [
                        count($field['validations']) > 0 ? $field['validations'][0] : 'nullable',
                        'in:' . implode(',', $field['values']),
                    ];
                }
                $rules_array[$fid . ".*"] = $children_validataions_array;
            }


            $rules_array[$fid] = $rule;

        }
        dd($rules_array);

        return $rules_array;
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
            $temp_field_obj = [
                "id"        => $field["id"],
                "data_type" => $field["data_type"],
                "slug"      => $field["slug"],
                ...$this->extractFieldProperties($field),
            ];
            if (isset($field['regex']) && $field['regex'] === 'VIN') {
                $temp_field_obj['slug'] = 'VIN';
            }
            $temp_field_obj["validations"] = $this->extractValidationRules($field["validation"]);
            $temp_field_obj["messages"]    = $this->extractValidationMessages($field['validation']);
            if (isset($field['values']) && count($field['values'])) {
                $temp_field_obj['values'] = $this->extractFieldValuesIntoArray($field['values']);
            }
            array_push($field_validations, $temp_field_obj);
        }

        return $field_validations;
    }

    public function extractFieldProperties($field)
    {
        $resultArr         = [];
        $parent_properties = ["min", "max"];
        $child_properties  = ["max_file_size"];
        foreach ($field['element']['params'] as $key => $value) {
            if (in_array($key, $parent_properties)) {
                $resultArr["parent_validations"][$key] = $value;
            } else {
                if (in_array($key, $child_properties)) {
                    $resultArr["child_validations"][$key] = $value;
                }
            }
        }
        if ($field['slug'] == "images") {
            $resultArr["child_validations"]["mimes"]     = "jpg,bmp,png";
            $resultArr["child_validations"]["data_type"] = "file";
        }
        if ($field['slug'] == "location") {
            $resultArr["child_validations"]["data_type"] = "float";
        }

        return $resultArr;
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
            $validationObj        = [];
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
        $messages      = [];
        foreach ($validationArr as $field) {
            foreach ($field['messages'] as $message) {
                $messages['fields.' . $field['id'] . '.' . key($message)] = current((array)$message);
            }
        }

        return $messages;
    }
}
