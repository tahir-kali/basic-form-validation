<?php

// app/Models/Form.php

namespace App\Models;

use App\Contracts\Models\FormInterface;
use App\Providers\FileServiceProvider;
use Illuminate\Database\Eloquent\Model;

final class Form extends Model implements FormInterface
{
    public function getFormMetaData(int $formIndex): array
    {
        $form = app(FileServiceProvider::class)->toArray("resources/json/form$formIndex.json");
        return data_get($form, 'fieldsets.*.fields.*.id');
    }
}
