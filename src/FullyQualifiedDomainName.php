<?php

declare(strict_types=1);

namespace Jolicht\DogadoFqdn;

use Webmozart\Assert\Assert;

use function rtrim;
use function str_starts_with;
use function substr;

class FullyQualifiedDomainName
{
    final protected function __construct(
        private readonly string $fullyQualifiedName,
        private readonly string $name
    ) {
    }

    public static function fromString(string $name): self
    {
        $name = rtrim($name, '.');

        $pattern = '/^(?!\-)(?:(?:[a-zA-Z\d_][_a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';

        if (str_starts_with($name, '_')) {
            Assert::regex(substr($name, 1), $pattern);
        } elseif (str_starts_with($name, '*.')) {
            Assert::regex(substr($name, 2), $pattern);
        } else {
            Assert::regex($name, $pattern);
        }

        return new static($name . '.', $name);
    }

    public function getFullyQualifiedName(): string
    {
        return $this->fullyQualifiedName;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
