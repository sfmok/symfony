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

/**
 * Used for the format of values.
 *
 * @author Mokhtar Tlili <tlili.mokhtar@gmail.com>
 */
abstract class AbstractFormat extends Constraint
{
    public string $format;
    public string $message = 'This value should be valid {{ format }}.';

    public function __construct(?string $message = null, ?array $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->message = $message ?? $this->message;
    }
}
