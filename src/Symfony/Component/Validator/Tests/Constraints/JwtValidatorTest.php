<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Tests\Constraints;

use Symfony\Component\Validator\Constraints\Jwt;
use Symfony\Component\Validator\Constraints\JwtValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

final class JwtValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): JwtValidator
    {
        return new JwtValidator();
    }

    public function testValidJwtValue(): void
    {
        $jwt = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c";
        $this->validator->validate($jwt, new Jwt());
        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidJwtValues
     */
    public function testInvalidJwtValue($value): void
    {
        $constraint = new Jwt(message: 'myMessage');
        $this->validator->validate($value, $constraint);
        $this->buildViolation('myMessage')
            ->setParameter('{{ value }}', '"'.$value.'"')
            ->setParameter('{{ format }}', $constraint->format)
            ->setCode(Jwt::INVALID_JWT_ERROR)
            ->assertRaised();
    }

    public function getInvalidJwtValues(): array
    {
        // Incorrect JSON in header
        $invalidHeader = base64_encode('{"alg": "HS256", "typ": "JWT""');
        $payload = base64_encode('{"sub": "1234567890", "name": "John Doe", "iat": 1516239022}');
        $signature = 'SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';
        $jwt = "$invalidHeader.$payload.$signature";

        return [
          ["eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9-eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ-SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"], // invalid format
          ["invalidheader.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"], // invalid header format
          ["eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.invalidpayload.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"], // invalid payload format
          [$jwt],
        ];
    }
}
