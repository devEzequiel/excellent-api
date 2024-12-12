<?php
namespace App\Domains\Client\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class CnpjValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        return;
    }
}
