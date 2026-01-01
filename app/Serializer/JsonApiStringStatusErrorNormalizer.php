<?php

namespace App\Serializer;

use ArrayObject;
use Illuminate\Support\Arr;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class JsonApiStringStatusErrorNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    public function __construct(
        private NormalizerInterface $decorated,
    ) {}

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|ArrayObject|null
    {
        // 1. Execute the original normalization
        $data = $this->decorated->normalize($object, $format, $context);

        // 2. Modify only if it's JSON:API and has errors
        if ($format === 'jsonapi' && isset($data['errors']) && is_array($data['errors'])) {
            foreach ($data['errors'] as $key => $error) {
                if (isset($error['status'])) {
                    // Force casting to string as per JSON:API spec
                    Arr::set($data, "errors.$key.status", (string) $error['status']);
                }
            }
        }

        return $data;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $this->decorated->supportsNormalization($data, $format, $context);
    }

    public function setSerializer(SerializerInterface $serializer): void
    {
        if ($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }

    public function getSupportedTypes(?string $format): array
    {
        return method_exists($this->decorated, 'getSupportedTypes')
            ? $this->decorated->getSupportedTypes($format)
            : ['*' => true];
    }
}
