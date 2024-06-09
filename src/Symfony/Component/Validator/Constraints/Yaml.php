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

use Symfony\Component\Validator\Exception\LogicException;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;

/**
 * Validates that a value is a valid yaml format.
 *
 * @author Mokhtar Tlili <tlili.mokhtar@gmail.com>
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Yaml extends AbstractFormat
{
    public const INVALID_YAML_ERROR = '8f14e45f-e6e5-4c6c-9c17-68f22a1f3dff';

    protected const ERROR_NAMES = [
        self::INVALID_YAML_ERROR => 'INVALID_YAML_ERROR',
    ];

    public string $format = 'YAML';

    /**
     * @param string[]|null                            $groups
     * @param array<string,mixed>                      $options
     */
    public function __construct(?array $options = null, ?string $message = null, ?array $groups = null, mixed $payload = null)
    {
        if (!class_exists(SymfonyYaml::class)) {
            throw new LogicException('The Yaml component is required to use the Yaml constraint. Try running "composer require symfony/yaml".');
        }

        parent::__construct($message, $options, $groups, $payload);
    }
}
