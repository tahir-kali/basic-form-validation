<?php

namespace App\Http\Requests\Form;

use App\Actions\Form\ForceFormRequestFieldsAction;
use App\Actions\Form\ValidateFormFieldsAction;
use App\Core\Http\Requests\CoreFormRequest;
use App\Http\Requests\Params\Form\StoreRequestParams;

class StoreRequest extends CoreFormRequest
{
    protected string $params = StoreRequestParams::class;

    protected array $validationArr = [];

    protected $fillable;

    protected string $formName = "";


    public function rules(ValidateFormFieldsAction $formAction, ForceFormRequestFieldsAction $action): array
    {
        //Extract validations and error messages
        $this->formName      = $this->input()['formName'];
        $this->validationArr = $formAction->execute($this->formName);

        //Set the $fillable property based on some dynamic form name
        parent::__construct();
        $this->fillable = $action->execute($this->formName);
//        dd([
//            "inputs" => $this->input(),
//            "fillable" => $this->fillable
//        ]);
        return $this->validationArr["rules_array"];
    }
}
