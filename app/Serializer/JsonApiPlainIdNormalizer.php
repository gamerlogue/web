<?php

declare(strict_types=1);

namespace App\Serializer;

use ApiPlatform\Metadata\IriConverterInterface;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\Metadata\Resource\Factory\ResourceNameCollectionFactoryInterface;
use App\Traits\DecoratesSerializer;
use ArrayObject;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;

class JsonApiPlainIdNormalizer implements DenormalizerInterface, NormalizerInterface, SerializerAwareInterface
{
    use DecoratesSerializer;

    /** @var array<string, class-string>|null */
    private ?array $resourceClassesByType = null;

    public function __construct(
        private readonly NormalizerInterface|DenormalizerInterface $decorated,
        private readonly IriConverterInterface $iriConverter,
        private readonly ResourceNameCollectionFactoryInterface $resourceNameCollectionFactory,
        private readonly ResourceMetadataCollectionFactoryInterface $resourceMetadataCollectionFactory,
    ) {}

    /**
     * -------------------------------------------------------------------------
     * NORMALIZATION (Output: Server -> Client)
     * -------------------------------------------------------------------------
     * Cleans IDs from IRIs to plain IDs for Data, Relationships and Included.
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|ArrayObject|null
    {
        $data = $this->decorated->normalize($data, $format, $context);

        if ($format !== 'jsonapi' || ! is_array($data)) {
            return $data;
        }

        return $this->cleanIdsRecursively($data);
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $this->decorated->supportsNormalization($data, $format, $context);
    }

    /**
     * -------------------------------------------------------------------------
     * DENORMALIZATION (Input: Client -> Server)
     * -------------------------------------------------------------------------
     * Rebuilds IRIs from plain IDs for Data, Relationships and Included.
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        // 1. Handling main data (single or collection)
        if (isset($data['data'])) {
            $data['data'] = $this->mapData($data['data'], $this->hydrateResource(...));
        }

        // 2. Handling included resources
        if (isset($data['included']) && is_array($data['included'])) {
            $data['included'] = array_map($this->hydrateResource(...), $data['included']);
        }

        return $this->decorated->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $this->decorated->supportsDenormalization($data, $type, $format, $context);
    }

    // -------------------------------------------------------------------------
    // PRIVATE HELPERS
    // -------------------------------------------------------------------------

    /**
     * Applies a callback to a single item or a list of items.
     * Handles the difference between a single resource and a collection.
     */
    private function mapData(mixed $data, callable $callback): mixed
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }

        if (array_is_list($data)) {
            return array_map($callback, $data);
        }

        return $callback($data);
    }

    /**
     * Takes a raw resource (array) and converts ID and Relationships to IRI.
     */
    private function hydrateResource(array $resource): array
    {
        // A. Convert the resource ID itself to IRI
        if (isset($resource['id'], $resource['type']) && ! str_contains((string) $resource['id'], '/')) {
            $resource['id'] = $this->buildIri($resource['type'], $resource['id']);
        }

        // B. Convert relationships
        if (isset($resource['relationships']) && is_array($resource['relationships'])) {
            foreach ($resource['relationships'] as $key => $relation) {
                if (! isset($relation['data'])) {
                    continue;
                }

                $resource['relationships'][$key]['data'] = $this->mapData($relation['data'], function ($item) {
                    if ($this->isPlainIdentifier($item)) {
                        $item['id'] = $this->buildIri($item['type'], $item['id']);
                    }

                    return $item;
                });
            }
        }

        return $resource;
    }

    private function isPlainIdentifier(mixed $item): bool
    {
        return is_array($item)
            && isset($item['id'], $item['type'])
            && ! str_contains((string) $item['id'], '/');
    }

    private function buildIri(string $type, string $id): string
    {
        return $this->iriConverter->getIriFromResource(
            $this->resolveResourceClass($type),
            context: ['uri_variables' => ['id' => $id]],
        ) ?? throw new NotNormalizableValueException("Unable to build an IRI for [$type].");
    }

    /**
     * @return class-string
     */
    private function resolveResourceClass(string $type): string
    {
        $this->resourceClassesByType ??= $this->mapTypesToResourceClasses();

        return $this->resourceClassesByType[$type]
            ?? throw new NotNormalizableValueException("Unknown JSON:API resource type [$type].");
    }

    /**
     * JSON:API types are the resource short names, so the mapping is whatever API Platform knows
     * about. Memoized per instance rather than cached: it only changes when the code does.
     *
     * @return array<string, class-string>
     */
    private function mapTypesToResourceClasses(): array
    {
        $classes = [];

        foreach ($this->resourceNameCollectionFactory->create() as $resourceClass) {
            foreach ($this->resourceMetadataCollectionFactory->create($resourceClass) as $resource) {
                if (($shortName = $resource->getShortName()) !== null) {
                    $classes[$shortName] = $resourceClass;
                }
            }
        }

        return $classes;
    }

    private function cleanIdsRecursively(array $data): array
    {
        // 1. Clean current ID
        if (isset($data['id']) && is_string($data['id']) && str_contains($data['id'], '/')) {
            $data['id'] = basename($data['id']);
        }

        // 2. Data (Document)
        if (isset($data['data'])) {
            $data['data'] = $this->mapData($data['data'], $this->cleanIdsRecursively(...));
        }

        // 3. Included (Document)
        if (isset($data['included']) && is_array($data['included'])) {
            $data['included'] = array_map($this->cleanIdsRecursively(...), $data['included']);
        }

        // 4. Relationships (Resource)
        if (isset($data['relationships']) && is_array($data['relationships'])) {
            foreach ($data['relationships'] as $key => $relation) {
                if (isset($relation['data'])) {
                    $data['relationships'][$key]['data'] = $this->mapData($relation['data'], $this->cleanIdsRecursively(...));
                }
            }
        }

        return $data;
    }
}
