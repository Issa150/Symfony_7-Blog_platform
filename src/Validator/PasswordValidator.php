<?php
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PasswordValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $errors = [];

        if (strlen($value) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
        }

        if (!preg_match('/\d/', $value)) {
            $errors[] = 'Password must contain at least one digit.';
        }

        if (!preg_match('/[A-Z]/', $value)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }

        if (!preg_match('/[a-z]/', $value)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }

        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $value)) {
            $errors[] = 'Password must contain at least one special character.';
        }

        if (count($errors) > 0) {
            $this->context->buildViolation('Invalid password')
                ->setParameter('{{ errors }}', implode('<br>', $errors))
                ->addViolation();
        }
    }
}