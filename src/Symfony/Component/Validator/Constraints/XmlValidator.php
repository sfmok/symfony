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
 * @author Mokhtar Tlili <tlili.mokhtar@gmail.com>
 */
class XmlValidator extends AbstractFormatValidator
{
    protected function validateFormat(string $value): bool
    {
        return false !== @simplexml_load_string($value);
    }

    protected function getErrorCode(): string
    {
        return Xml::INVALID_XML_ERROR;
    }
}
