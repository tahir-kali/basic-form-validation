<?php

namespace App\Http\Requests\Params\Form;

use App\Core\Http\Requests\Params\RequestParams;
use Illuminate\Http\UploadedFile;

class StoreRequestParams extends RequestParams
{
    public function __construct(
        public array $fields,
        public string $formName
    ) {
    }
}
