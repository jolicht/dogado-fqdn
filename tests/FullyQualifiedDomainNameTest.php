<?php

declare(strict_types=1);

namespace Jolicht\DogadoFqdn\Tests;

use Jolicht\DogadoFqdn\FullyQualifiedDomainName;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Jolicht\DogadoFqdn\FullyQualifiedDomainName
 */
class FullyQualifiedDomainNameTest extends TestCase
{
    /**
     * @dataProvider validDomainNameDataProvider
     */
    public function test_fromString_ValidDomainName_ReturnsFullyQualifiedDomainName(
        string $domainName,
        string $expectedFqdn
    ): void {
        $fqdn = FullyQualifiedDomainName::fromString($domainName);
        $this->assertInstanceOf(FullyQualifiedDomainName::class, $fqdn);
        $this->assertSame($expectedFqdn, $fqdn->getFullyQualifiedName());
    }

    private function validDomainNameDataProvider(): array
    {
        return [
            'simple_domain_name' => ['test.at', 'test.at.'],
            'simple_domain_name_with_trailing_dot' => ['test.at.', 'test.at.'],
            'starts_with_underscore' => ['_test.at', '_test.at.'],
            'starts_with_asterisk_and_dot' => ['*.test.at', '*.test.at.'],
        ];
    }

    public function test_getFullyQualifiedName_HasFullyQualifiedName_ReturnsFullyQualifiedName(): void
    {
        $fqdn = FullyQualifiedDomainName::fromString('test.at');
        $this->assertSame('test.at.', $fqdn->getFullyQualifiedName());
    }

    public function test_getName_HasName_ReturnsName(): void
    {
        $fqdn = FullyQualifiedDomainName::fromString('test.at.');
        $this->assertSame('test.at', $fqdn->getName());
    }
}
