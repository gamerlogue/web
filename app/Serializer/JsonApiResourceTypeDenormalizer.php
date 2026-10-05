<?php

declare(strict_types=1);

namespace App\Serializer;

use ApiPlatform\Metadata\Operation;
use App\Traits\DecoratesSerializer;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;

/**
 * API Platform ignores the JSON:API `type` member of a request document. The spec requires a
 * mismatch with the endpoint's resource to be answered with 409 Conflict.
 *
 * @see https://jsonapi.org/format/#crud-updating-responses-409
 */
readonly class JsonApiResourceTypeDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    use DecoratesSerializer;

    public function __construct(
        private DenormalizerInterface $decorated,
    ) {}

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $operation = $context['operation'] ?? null;
        $requestedType = $data['data']['type'] ?? null;

        if ($operation instanceof Operation && $requestedType !== null && $requestedType !== $operation->getShortName()) {
            throw new ConflictHttpException("The resource type [$requestedType] does not match the endpoint's [{$operation->getShortName()}].");
        }

        return $this->decorated->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $this->decorated->supportsDenormalization($data, $type, $format, $context);
    }
}
