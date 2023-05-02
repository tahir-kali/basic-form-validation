<?php

namespace App\Http\Requests\Form;

use App\Actions\Form\ForceFormRequestFieldsAction;
use App\Actions\Form\ValidateFormFieldsAction;
use App\Core\Http\Requests\CoreFormRequest;
use App\Http\Requests\Params\Form\StoreRequestParams;
use App\Models\Form;
use Illuminate\Support\Facades\Validator;

class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;

    protected array $validationArr = [];

    protected string $formName = "form1";


    public function rules(ValidateFormFieldsAction $formAction): array
    {
        //Extract validations and error messages
        if (isset($this->input()['formName'])) {
            $this->formName = $this->input()['formName'];
        }
        $this->validationArr = $formAction->execute($this->formName);

        return $this->validationArr["rules_array"];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        $form = $this->formName === "form1" ? Form::getForm1() : Form::getForm2();
        //        force populate fields that are not supplied!
        foreach($form as $field){
           if(!isset($data["fields"][$field])) $data["fields"][$field] = null;
        }

        return $data;
    }

}
