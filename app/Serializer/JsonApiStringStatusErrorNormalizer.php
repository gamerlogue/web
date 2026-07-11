<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Traits\DecoratesSerializer;
use ArrayObject;
use Illuminate\Support\Arr;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;

readonly class JsonApiStringStatusErrorNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use DecoratesSerializer;

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
}
