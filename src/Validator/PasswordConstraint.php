<?php

// src/Validator/PasswordConstraint.php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class PasswordConstraint extends Constraint
{
    public $message = 'Invalid password: {{ errors }}';

    // public function validatedBy()
    // {
    //     return 'password_validator';
    // }
}