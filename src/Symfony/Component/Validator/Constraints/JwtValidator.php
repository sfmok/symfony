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
class JwtValidator extends AbstractFormatValidator
{
    protected function validateFormat(string $value): bool
    {
        // Split the JWT into its three parts
        $parts = explode('.', $value);

        // JWT should have exactly three parts
        if (count($parts) !== 3) {
            return false;
        }

        [$header, $payload, $signature] = $parts;

        // Replace URL-safe characters with standard Base64 characters and decode
        $decodedHeader = base64_decode(strtr($header, '-_', '+/'));
        $decodedPayload = base64_decode(strtr($payload, '-_', '+/'));

        // Check if the decoded header and payload are valid JSON
        if (!json_validate($decodedHeader) || !json_validate($decodedPayload)) {
            return false;
        }

        // At this point, it looks like a JWT
        return true;
    }

    protected function getErrorCode(): string
    {
        return Jwt::INVALID_JWT_ERROR;
    }
}
