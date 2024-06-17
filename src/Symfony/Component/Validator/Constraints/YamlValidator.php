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

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;

/**
 * @author Mokhtar Tlili <tlili.mokhtar@gmail.com>
 */
class YamlValidator extends AbstractFormatValidator
{
    protected function validateFormat(string $value): bool
    {
        try {
            SymfonyYaml::parse($value);
            return true;
        } catch (ParseException) {
            return false;
        }
    }

    protected function getErrorCode(): string
    {
        return Yaml::INVALID_YAML_ERROR;
    }
}
