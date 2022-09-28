<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class filterRule implements Rule
{
    protected $forbidden;

    public function __construct($forbidden)
    {
        $this->forbidden = $forbidden;
    }

    public function passes($attribute, $value)
    {
        return !in_array(strtolower($value), $this->forbidden);
    }

    public function message()
    {
        return 'The validation error message.';
    }
}
