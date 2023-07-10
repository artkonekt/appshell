<?php

declare(strict_types=1);

/**
 * Contains the CurrencyExists validation rule class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-07-10
 *
 */

namespace Konekt\AppShell\Validation;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Konekt\AppShell\Helpers\Currencies;

class CurrencyExists implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Currencies::exists((string) $value)) {
            $fail('The :attribute must be a valid currency');
        }
    }
}
