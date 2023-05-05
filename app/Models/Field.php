<?php

namespace App\Models;

use App\Contracts\Models\FieldInterface;
use App\Providers\FileServiceProvider;
use App\Rules\MaxFileSizeRule;
use App\Rules\MaxRule;
use App\Rules\MinRule;
use App\Rules\RangeRule;
use App\Rules\RequiredRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Field extends Model implements FieldInterface
{
    use HasFactory;
    public static function getFields(): array
    {
        return app(FileServiceProvider::class)->toArray('resources/json/fields.json');
    }


}
