<?php

namespace App\Http\Requests\Form;

use App\Core\Http\Requests\CoreFormRequest;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Models\Form;
use App\Rules\LocationRule;
use App\Rules\VINRule;

class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;

    public function rules(): array
    {
        $form                    = $this->input()['formName'];
        $rules_array             = [];
        $validationArr           = $this->articulateValidations($form);
        $mapValidationProperties = [
            "max_file_size" => "max",
        ];
//        dd($validationArr);
        foreach ($validationArr as $field) {
            $field_id = 'fields.' . $field['id'];
            if (!empty($field['validations'])) {
                $rule = [$field['validations'][0], $field['data_type'], ...array_slice($field["validations"], 1)];
            } else {
                $rule = ['nullable', $field['data_type']];
            }
            //Add extra parent validations to rule array
            if (isset($field['parent_validations']) && !empty($field['parent_validations'])) {
                foreach ($field['parent_validations'] as $key => $value) {
                    array_push($rule, "$key:$value");
                }
            }
//            Add custom validations start
            if ($field['slug'] === 'location') {
                array_push($rule, new LocationRule);
            }
            if ($field['slug'] === 'VIN') {
                array_push($rule, new VINRule);
            }
//            Add custom validations end
            if ($field['data_type'] !== 'array' && isset($field['values']) && !empty($field['values'])) {
                array_push($rule, 'in:' . implode(',', $field['values']));
            }
            if ($field['data_type'] === 'array') {
                $children_validations_array = [
                ];
                if (isset($field['values']) && !empty($field['values'])) {
                    $children_validations_array = [
                        'in:' . implode(',', $field['values']),
                    ];
                }
                if (isset($field['child_validations']) && !empty($field['child_validations'])) {
                    $keysToIgnore = ["data_type", "required"];
                    foreach ($field['child_validations'] as $key => $val) {
                        $key = isset($mapValidationProperties[$key]) ? $mapValidationProperties[$key] : $key;
                        if (!in_array($key, $keysToIgnore)) {
                            array_push($children_validations_array, "$key:$val");
                        } else {
                            array_push($children_validations_array, "$val");
                        }
                    }
                }
                $rules_array[$field_id . ".*"] = $children_validations_array;
            }
            $rules_array[$field_id] = $rule;
        }
//        dd($rules_array);
//    dd($this->input());
        return $rules_array;
    }

    public function validateFieldMetaData($field)
    {
        if (!isset($field['id']) || !isset($field['data_type']) || !isset($field["validation"])) {
            trigger_error("Invalide field", E_USER_ERROR);
        }
    }

    public function articulateValidations($form)
    {
        $form              = $form === "form1" ? Form::getForm1() : Form::getForm2();
        $field_meta_data   = Form::getFields();
        $field_validations = [];
        foreach ($field_meta_data as $field) {
            if (!in_array($field['id'], $form)) {
                continue;
            }
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
            if (isset($field['values']) && !empty($field['values'])) {
                $temp_field_obj['values'] = $this->extractFieldValuesIntoArray($field['values']);
            }
            array_push($field_validations, $temp_field_obj);
        }

        return $field_validations;
    }

    public function extractFieldProperties($field)
    {
        $resultArr = [
            "parent_validations" => [],
            "child_validations"  => [],
        ];

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
        if ($field['data_type'] === "string") {
            $resultArr["parent_validations"]["min"] = 5;
            $resultArr["parent_validations"]["max"] = 255;
        }
        if ($field['data_type'] === "integer") {
            $resultArr["parent_validations"]["min"] = 1;
            $resultArr["parent_validations"]["max"] = 100;
        }
        if ($field['slug'] === 'location') {
            $resultArr["child_validations"]["required"] = "required";
        }

        return $resultArr;
    }

    public function extractValidationRules($validation)
    {
        $validation_arr = [];
        $keys_to_ignore = ["min", "max"];
        foreach ($validation as $validation) {
            $rule = $validation['rule']; // required, min, max
            if ($rule == "number" || in_array($rule, $keys_to_ignore)) {
                continue;
            }
            $params           = $validation['params'];
            $validationString = $rule;
            if (!empty($params)) {
                if($rule!=="range"){
                    $validationString .= "|" . implode(",", $params);
                }else{
                    $validationString = "between";
                    $validationString .= ":" . implode(",", $params);
                }

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
        $form          = $this->input()['formName'];
        $validationArr = $this->articulateValidations($form);
        $messages      = [];
        foreach ($validationArr as $field) {
            foreach ($field['messages'] as $message) {
                $messages['fields.' . $field['id'] . '.' . key($message)] = current((array)$message);
            }
        }

        return $messages;
    }
}
