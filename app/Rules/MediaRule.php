<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MediaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    protected string $mediaType;
    protected array $allowedImageMimeTypes = [
        'jpeg','png','gif','bmp','webp','tiff','svg','application/octet-stream'
    ];

    public function __construct($mediaType)
    {
        $this->mediaType = $mediaType;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $baseMime = $value->getClientMimeType();
        $mimeType = explode("/", $baseMime);
        //Validate image uploads
        if(!in_array($this->mediaType,$mimeType) && !in_array($baseMime,$this->allowedImageMimeTypes)){
            $fail("Please upload only $this->mediaType");
        }



    }
}
