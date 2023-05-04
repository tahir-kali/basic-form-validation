<?php
namespace App\Http\Requests\Form;
use App\Actions\Form\ValidateFormFieldsAction;
use App\Core\Http\Requests\CoreFormRequest;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Models\Form;
use App\Models\FormValidator;
use Illuminate\Support\Facades\Cache;

class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;
    protected array $validationArr = [];
    protected int $formId = 1;
    public function rules(): array
    {
        $this->formId = intval($this->input('formId'));
        $formValidator = new FormValidator($this->formId);
        // Cache the form validations
        $cacheKey = 'form_validations_' . $this->formId;
        $this->validationArr = $formValidator->execute();
        return $this->validationArr["rules_array"];
    }
    public function all($keys = null)
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

