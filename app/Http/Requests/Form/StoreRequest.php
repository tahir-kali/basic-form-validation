<?php

namespace App\Http\Requests\Form;

use App\Core\Http\Requests\CoreFormRequest;
use App\Facades\FormValidatorServiceFacade;
use App\Facades\LogServiceFacade;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Models\Form;
use Carbon\Carbon;

class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;

    protected array $fields;

    public function rules(): array
    {
        $data            = $this->input();
        $formId          = intval($data['formId']);
        $form            = new Form();
        $this->fields    = $form->getFormFields($formId);
        $validationArray = FormValidatorServiceFacade::execute($formId);
        dd($validationArray);
        return $validationArray;
    }

    public function all($keys = null): array
    {
        $data = parent::all($keys);
        // Force populate fields that are not supplied!
        foreach ($this->fields as $field) {
            if (!array_key_exists($field, $data['fields'])) {
                $data['fields'][$field] = null;
            }
        }

        return $data;
    }
}

