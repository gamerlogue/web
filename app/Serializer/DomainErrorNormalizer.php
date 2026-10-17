<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Traits\DecoratesSerializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;

/**
 * API Platform sets an error's `code` to its HTTP status. An ApiDomainException carries a specific
 * one in its X-Error-Code header, which survives the conversion to API Platform's Error resource.
 */
final readonly class DomainErrorNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use DecoratesSerializer;

    public function __construct(private NormalizerInterface $decorated) {}

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $this->decorated->supportsNormalization($data, $format, $context);
    }

    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $result = $this->decorated->normalize($data, $format, $context);
        $code = method_exists($data, 'getHeaders') ? ($data->getHeaders()['X-Error-Code'] ?? null) : null;
        if (is_array($result) && is_string($code)) {
            foreach (array_keys($result['errors']) as $key) {
                $result['errors'][$key]['code'] = $code;
            }
        }

        return $result;
    }
}
