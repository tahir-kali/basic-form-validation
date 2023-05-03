<?php
namespace App\Http\Requests\Form;

use App\Actions\Form\ForceFormRequestFieldsAction;
use App\Actions\Form\ValidateFormFieldsAction;
use App\Core\Http\Requests\CoreFormRequest;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Models\Form;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;
    protected array $validationArr = [];

    protected string $formName = "form1";

    public function rules(ValidateFormFieldsAction $formAction): array
    {
        // Cache the form validations
        $cacheKey = 'form_validations_' . $this->formName;
        $this->validationArr = Cache::rememberForever($cacheKey, function () use ($formAction) {
            return $formAction->execute($this->formName);
        });

        // Extract validations and error messages
        if ($this->filled('formName')) {
            $this->formName = $this->input('formName');
            $cacheKey = 'form_validations_' . $this->formName;
            $this->validationArr = Cache::rememberForever($cacheKey, function () use ($formAction) {
                return $formAction->execute($this->formName);
            });
        }

        return $this->validationArr["rules_array"];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $form = $this->formName === "form1" ? Form::getForm1() : Form::getForm2();

        // Force populate fields that are not supplied!
        foreach ($form as $field) {
            if (!array_key_exists($field, $data["fields"])) {
                $data["fields"][$field] = null;
            }
        }

        return $data;
    }
}

