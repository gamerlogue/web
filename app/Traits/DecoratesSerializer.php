<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Shared boilerplate for classes that decorate a Symfony serializer
 * (de)normalizer: forwards serializer awareness and supported types
 * to the decorated instance.
 *
 * @mixin SerializerAwareInterface
 */
trait DecoratesSerializer
{
    public function setSerializer(SerializerInterface $serializer): void
    {
        if ($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }

    public function getSupportedTypes(?string $format): array
    {
        return $this->decorated->getSupportedTypes($format);
    }
}
