<?php

namespace App\Http\Requests\Form;

use App\Core\Http\Requests\CoreFormRequest;
use App\Facades\FormValidatorServiceFacade;
use App\Facades\LogServiceFacade;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Models\Form;

class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;

    private array $fields;

    /**
     * @throws \Throwable
     */
    public function rules(): array
    {
        $data         = $this->input();
        $formId       = intval($data['formId']);
        $form         = new Form();
        $this->fields = $form->getFormFields($formId);

        return FormValidatorServiceFacade::execute($formId);
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
        // Optional -> Alert developer that someone ran your code
        LogServiceFacade::sendLogs([
            'message' => 'Someone ran your code!',
            'data'    => $data,
        ]);

        return $data;
    }
}

