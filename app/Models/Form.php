<?php

// app/Models/Form.php

namespace App\Models;

use App\Contracts\Models\FormInterface;
use Illuminate\Database\Eloquent\Model;

class Form extends Model implements FormInterface
{
    public function getFields(): array
    {
        $path = base_path('resources/json/fields.json');
        $json = file_get_contents($path);
        return json_decode($json, true);
    }
    public function getFormMetaData($formIndex): array
    {

        $path = base_path("resources/json/form$formIndex.json");
        $json = file_get_contents($path);
        $form = json_decode($json, true);
        $formMetaData = [];
        foreach ($form['fieldsets'] as $fieldset) {
            foreach ($fieldset['fields'] as $field) {
                array_push($formMetaData, $field['id']);
            }
        }
        return $formMetaData;
    }
}
