<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Provides a base class for the validation of value format.
 *
 * @author Mokhtar Tlili <tlili.mokhtar@gmail.com>
 */
abstract class AbstractFormatValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof AbstractFormat) {
            throw new UnexpectedTypeException($constraint, AbstractFormat::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!\is_scalar($value) && !$value instanceof \Stringable) {
            throw new UnexpectedValueException($value, 'string');
        }

        if ($this->validateFormat((string) $value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $this->formatValue($value))
            ->setParameter('{{ format }}', $constraint->format)
            ->setCode($this->getErrorCode())
            ->addViolation();
    }

    /**
     * Validate format value
     */
    abstract protected function validateFormat(string $value): bool;

    abstract protected function getErrorCode(): string;
}
