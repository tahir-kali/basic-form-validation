<?php
namespace App\Http\Requests\Form;
use App\Core\Http\Requests\CoreFormRequest;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Models\Form;
use App\Providers\FormValidatorServiceProvider;
class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;
    protected int $formId;
    public function rules(): array
    {
        $this->formId = intval($this->input('formId'));
        $validationArr  = app(FormValidatorServiceProvider::class)->execute($this->formId);

        return $validationArr["rules_array"];
    }
    public function all($keys = null): array
    {
        $data = parent::all($keys);
        $form = new Form();
        $formFields = $form->getFormMetaData($this->formId);
        // Force populate fields that are not supplied!
        foreach ($formFields as $field) {
            if (!array_key_exists($field, $data["fields"])) {
                $data["fields"][$field] = null;
            }
        }
        return $data;
    }
}

