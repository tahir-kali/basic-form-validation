<?php

// app/Models/Form.php

namespace App\Models;

use App\Contracts\Models\FormInterface;
use Illuminate\Database\Eloquent\Model;

class Form extends Model implements FormInterface
{
    public function getFileAndConvertToArray($path): array {
        return json_decode(file_get_contents(base_path($path)),true);
    }
    public function getFields(): array
    {
        return $this->getFileAndConvertToArray('resources/json/fields.json');
    }
    public function getFormMetaData($formIndex): array
    {
        $form = $this->getFileAndConvertToArray("resources/json/form$formIndex.json");
        $formMetaData = [];
        foreach ($form['fieldsets'] as $fieldset) {
            foreach ($fieldset['fields'] as $field) {
                array_push($formMetaData, $field['id']);
            }
        }
        return $formMetaData;
    }
}
