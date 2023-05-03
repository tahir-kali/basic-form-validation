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

    public function __construct($mediaType)
    {
        $this->mediaType = $mediaType;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $mimeType = explode("/", $value->getClientMimeType())[0];
        //Validate image uploads
        if($mimeType !== $this->mediaType) $fail("Please upload only $this->mediaType");



    }
}
