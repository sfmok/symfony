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

/**
 * Validates that a value is a valid jwt format.
 *
 * @author Mokhtar Tlili <tlili.mokhtar@gmail.com>
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Jwt extends AbstractFormat
{
    public const INVALID_JWT_ERROR = '8f14e45f-e6e5-4c6c-9c17-68f22a1f3dff';

    protected const ERROR_NAMES = [
        self::INVALID_JWT_ERROR => 'INVALID_JWT_ERROR',
    ];

    public string $format = 'JWT';
}
