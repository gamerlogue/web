<?php

declare(strict_types=1);

namespace App\Serializer;

use Illuminate\Support\Facades\Context;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Adds to a JSON:API collection's `meta` what a query extension computed for the request, such as
 * the average rating of a game's reviews. Read from Context, never from instance state (Octane),
 * and pulled so it reaches the outermost collection only.
 */
final readonly class CollectionMetaNormalizer implements NormalizerAwareInterface, NormalizerInterface
{
    public const string CONTEXT = 'collection_meta';

    public function __construct(private NormalizerInterface $decorated) {}

    public function setNormalizer(NormalizerInterface $normalizer): void
    {
        if ($this->decorated instanceof NormalizerAwareInterface) {
            $this->decorated->setNormalizer($normalizer);
        }
    }

    public function getSupportedTypes(?string $format): array
    {
        return $this->decorated->getSupportedTypes($format);
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $this->decorated->supportsNormalization($data, $format, $context);
    }

    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        // Pulled before delegating: the outermost collection is normalized first, but its nested
        // collections finish first.
        $meta = Context::pullHidden(self::CONTEXT);
        $result = $this->decorated->normalize($data, $format, $context);
        if (is_array($result) && is_array($meta)) {
            $result['meta'] = ($result['meta'] ?? []) + $meta;
        }

        return $result;
    }
}
