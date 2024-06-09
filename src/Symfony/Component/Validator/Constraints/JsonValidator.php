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
 * @author Imad ZAIRIG <imadzairig@gmail.com>
 */
class JsonValidator extends AbstractFormatValidator
{
    protected function validateFormat(string $value): bool
    {
        return json_validate($value);
    }

    protected function getErrorCode(): string
    {
        return Json::INVALID_JSON_ERROR;
    }
}
