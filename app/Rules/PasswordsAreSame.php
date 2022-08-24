<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordsAreSame implements Rule
{
    public $password1, $password2;
    /**
     * Create a new rule instance.
     *
     * @return bool
     * @param text $password 
     */

    public function __construct($password1, $password2)
    {
        $this->password1 = $password1;
        $this->password2 = $password2;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return strcmp($this->password1, $this->password2) == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Passwords do not match.';
    }
}
