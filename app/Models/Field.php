<?php

namespace App\Models;

use App\Contracts\Models\FieldInterface;
use App\Providers\FileServiceProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model implements FieldInterface
{
    use HasFactory;
    public static function getAll(): array
    {
        return app(FileServiceProvider::class)->toArray('resources/json/fields.json');
    }


}
