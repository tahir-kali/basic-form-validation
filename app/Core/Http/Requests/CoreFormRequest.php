<?php

namespace App\Core\Http\Requests;

use App\Core\Http\Requests\Params\RequestParams;
use Illuminate\Foundation\Http\FormRequest;

abstract class CoreFormRequest extends FormRequest
{
    protected string $params = RequestParams::class;

    public function getParams(): RequestParams
    {
        return $this->params::fromRequest($this);
    }
}
