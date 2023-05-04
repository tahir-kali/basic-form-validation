<?php
namespace App\Models;

use App\Contracts\Models\FormValidatorInterface;
use App\Rules\ArrayRule;
use App\Rules\InRule;
use App\Rules\LocationRule;
use App\Rules\MaxFileSizeRule;
use App\Rules\MaxRule;
use App\Rules\MediaRule;
use App\Rules\MinRule;
use App\Rules\NumberRule;
use App\Rules\RangeRule;
use App\Rules\RequiredRule;
use App\Rules\StringRule;
use App\Rules\VINRule;

class FormValidator implements FormValidatorInterface
{
    private int $formId;
    public function __construct($formId)
    {
        $this->formId = $formId;
    }
    public function execute(): array
    {
        $validations   = $this->articulateValidations();
        $validationArr = [
            "rules_array" => [],
            "messages"    => [...$this->returnProperErrorMessages($validations)],
        ];
        foreach ($validations as $field) {
            $data_type_classes = [
                "string" => new StringRule($field),
                "integer" => new NumberRule($field),
                "array"  => new ArrayRule($field),
            ];
            $field_id          = 'fields.' . $field['id'];
            if (!empty($field['validations'])) {
                $rule = [
                    $field['validations'][0],
                    $data_type_classes[$field['data_type']],
                    ...array_slice($field["validations"], 1),
                ];
            } else {
                $rule = ['nullable', $field['data_type']];
            }
            //Add extra parent validations to rule array
            if (isset($field['parent_validations']) && !empty($field['parent_validations'])) {
                foreach ($field['parent_validations'] as $value) {
                    array_push($rule, $value);
                }
            }
            //Add custom validations start
            if ($field['slug'] === 'location') {
                array_push($rule, new LocationRule);
            }
            if ($field['slug'] === 'VIN') {
                array_push($rule, new VINRule);
            }

            if ($field['data_type'] === 'array') {
                $children_validations_array = [
                ];
                if (isset($field['values']) && !empty($field['values'])) {
                    $children_validations_array = [
                        new InRule($field),
                    ];
                }
                if (isset($field['child_validations']) && !empty($field['child_validations'])) {
                    $keysToIgnore = ["data_type", "required"];
                    foreach ($field['child_validations'] as $key => $val) {
                        $key = isset($mapValidationProperties[$key]) ? $mapValidationProperties[$key] : $key;
                        if (!in_array($key, $keysToIgnore)) {
                            array_push($children_validations_array, $val);
                        }
                    }
                }
                $validationArr['rules_array'][$field_id . ".*"] = $children_validations_array;
            }
            $validationArr['rules_array'][$field_id] = $rule;
        }
        return $validationArr;
    }

    public function validateFieldMetaData(array $field): void
    {
        if (!isset($field['id']) || !isset($field['data_type']) || !isset($field["validation"])) {
            trigger_error("Invalide field", E_USER_ERROR);
        }
    }

    public function articulateValidations(): array
    {
        $form              = new Form();
        $formMetaData = $form->getFormMetaData($this->formId);
        $field_meta_data   = $form->getFields();
        $field_validations = [];
        foreach ($field_meta_data as $field) {
            if (!in_array($field['id'], $formMetaData)) {
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
            $temp_field_obj["validations"] = $this->extractValidationRules($field);
            $temp_field_obj["messages"]    = $this->extractValidationMessages($field['validation']);
            if (isset($field['values']) && !empty($field['values'])) {
                $temp_field_obj['values'] = new InRule($field);
            }
            array_push($field_validations, $temp_field_obj);
        }

        return $field_validations;
    }

    public function extractFieldProperties(array $field): array
    {
        $resultArr = [
            "parent_validations" => [],
            "child_validations"  => [],
        ];

        $parent_properties = [

            "min_value" => new MinRule($field),
            "mix_value" => new MinRule($field),
            "max_value" => new MaxRule($field),

        ];
        $child_properties  = ["max_file_size" => new MaxFileSizeRule($field)];
        foreach ($field['element']['params'] as $key => $value) {
            if (isset($parent_properties[$key])) {
                $resultArr["parent_validations"][$key] = $parent_properties[$key];
            } else {
                if (in_array($key, $child_properties)) {
                    $resultArr["child_validations"][$key] = $value;
                }
            }
        }
//        extract special keys here
        foreach ($field['validation'] as $validation) {
            foreach ($validation["params"] as $key => $val) {
                $resultArr['parent_validations'][$key] = $parent_properties[$key];
            }
        }
        if ($field['slug'] == "images") {
            array_push($resultArr["child_validations"], new MediaRule("image"));
        }

        if ($field['slug'] === 'location') {
            $resultArr["child_validations"]["required"] = new RequiredRule($field);
        }

        return $resultArr;
    }
    public function extractValidationRules($field): array
    {
        $validation_arr = [];
        $keys_to_ignore    = ["min", "max"];
        $validationClasses = [
            "required"  => new RequiredRule($field),
            "min"       => new MinRule($field),
            "max"       => new MaxRule($field),
            "min_value" => new MinRule($field),
            "mix_value" => new MinRule($field),
            "max_value" => new MaxRule($field),
            "range"     => new RangeRule($field)
        ];
        foreach ($field['validation'] as $validation) {
            $rule = $validation['rule']; // required, min, max
            if(in_array($rule,$keys_to_ignore)) continue;
            if (isset($validationClasses[$rule])) {
                array_push($validation_arr, $validationClasses[$rule]);
            }
        }
        return $validation_arr;
    }
    public function extractValidationMessages($validation): array
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
    public function returnProperErrorMessages($validation): array
    {
        $messages = [];
        foreach ($validation as $field) {
            foreach ($field['messages'] as $message) {
                $messages['fields.' . $field['id'] . '.' . key($message)] = current((array)$message);
            }
        }
        return $messages;
    }

}
