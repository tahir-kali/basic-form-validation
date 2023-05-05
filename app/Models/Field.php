<?php

namespace App\Models;

use App\Contracts\Models\FieldInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model implements FieldInterface
{
    use HasFactory;
    public static function getFields(): array
    {
        return convertFileToArray('resources/json/fields.json');
    }


}
