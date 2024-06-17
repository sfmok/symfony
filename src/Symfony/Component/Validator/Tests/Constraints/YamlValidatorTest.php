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

use Symfony\Component\Validator\Constraints\Yaml;
use Symfony\Component\Validator\Constraints\YamlValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Symfony\Component\Validator\Tests\Constraints\Fixtures\StringableValue;

final class YamlValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): YamlValidator
    {
        return new YamlValidator();
    }

    /**
     * @dataProvider getValidYamlValues
     */
    public function testValidYamlValue($value): void
    {
        $this->validator->validate($value, new Yaml());
        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidYamlValues
     */
    public function testInvalidYamlValue($value): void
    {
        $constraint = new Yaml(message: 'myMessage');
        $this->validator->validate($value, $constraint);
        $this->buildViolation('myMessage')
            ->setParameter('{{ value }}', '"'.$value.'"')
            ->setParameter('{{ format }}', strtoupper($constraint->format))
            ->setCode(Yaml::INVALID_YAML_ERROR)
            ->assertRaised();
    }

    public static function getValidYamlValues(): array
    {
        $yaml1 = <<<YAML
string: "value with special characters: !@#$%^&*()"
multiline: |
  This is a
  multiline
  string.
YAML;
        $yaml2 = <<<YAML
key: value
#address
address:
  items:
    - item1
    - item2
    - item3
  address:
    country: Tunisia
    city: Kebili
    zip_code: 4230
YAML;

        return [
            [''],
            [null],
            ["null"],
            ["test: ~"],
            ["test: null"],
            ["test: foobar"],
            ["test: \'@foobar\'"],
            ["test: \"@foobar\""],
            ["test: \'%project%\'"],
            ["foo:\t bar"],
            ["yaml:\n   test: \'@test\'"],
            ["parent: { child: first }"],
            ["name: John Doe\nemail: john.doe@example.com\nroles:\n  admin:\n    user: test\n"],
            [new StringableValue("test: [foobar, test]")],
            [$yaml1],
            [$yaml2],
        ];
    }

    public static function getInvalidYamlValues(): array
    {
        $yaml = <<<YAML
key: value
#address
address:
  items:
    - item1
    item2
    - item3
  address:
    country: Tunisia
    city:Kebili
    zip code: 4230
YAML;
        return [
            ["foo:\n\tbar"],
            ["!test:"],
            ["parent: { child: first, child: duplicate }"],
            ["test: @test"],
            ["test: %test%"],
            [$yaml],
        ];
    }
}
