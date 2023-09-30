<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateDiscountValue implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        
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
        $discountType = $_REQUEST['discount_type'];

        return $discountType === '%' && $value > 0 && $value < 100;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Giá trị giảm giá nằm trong khoảng 0 đến 100%.';
    }
}
