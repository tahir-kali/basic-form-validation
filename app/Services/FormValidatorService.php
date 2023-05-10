<?php

namespace App\Services;

use App\Contracts\Models\FormValidatorInterface;
use App\Facades\ExceptionServiceFacade;
use App\Facades\FieldServiceFacade;
use App\Models\Field;
use App\Models\Form;
use App\Rules\InRule;
use App\Rules\LocationRule;
use App\Rules\VINRule;

final class FormValidatorService implements FormValidatorInterface
{
    private int $formId;

    public function execute(int $formId): array
    {
        $this->formId  = $formId;
        $validations   = $this->articulateValidations();
        $validationArr = [];
        foreach ($validations as $field) {
            $data_type_classes = FieldServiceFacade::getDataTypeRules($field);
            $field_id          = 'fields.' . $field['id'];
            $rule              = [...$field['validations'], $data_type_classes[$field['data_type']]];
            //Add extra parent validations to rule array
            if ($field['data_type'] === 'array' && isset($field['child_validations'])) {
                $validationArr[$field_id . ".*"] = $field['child_validations'];
            }
            $validationArr[$field_id] = $rule;
        }
        return $validationArr;
    }

    public function articulateValidations(): array
    {
        $form              = new Form();
        $formMetaData      = $form->getFormMetaData($this->formId);
        $field_meta_data   = Field::getAll();
        $field_validations = [];
        foreach ($field_meta_data as $field) {
            if (!in_array($field['id'], $formMetaData)) {
                continue;
            }
            if (!FieldServiceFacade::validateFieldMetaData($field)) ExceptionServiceFacade::throwError('invalid_meta_data');
            $temp_field_obj                = [
                "id"         => $field["id"],
                "data_type"  => $field["data_type"],
                "slug"       => $field["slug"],
                "validation" => $field["validation"],
                ...FieldServiceFacade::returnAdditionalFieldProperties($field),
            ];
            $temp_field_obj["validations"] = FieldServiceFacade::extractValidationRules($field);
            if (!empty($field['values'])) {
                $temp_field_obj['values'] = FieldServiceFacade::getValuesCSV($field);
            }
            $field_validations[] = $temp_field_obj;
        }
        return $field_validations;
    }
}


