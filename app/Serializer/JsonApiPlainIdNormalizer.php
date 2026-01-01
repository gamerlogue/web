<?php

namespace App\Serializer;

use ArrayObject;
use Illuminate\Support\Str;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class JsonApiPlainIdNormalizer implements DenormalizerInterface, NormalizerInterface, SerializerAwareInterface
{
    private string $routePrefix;

    public function __construct(
        private NormalizerInterface|DenormalizerInterface $decorated,
    ) {
        $this->routePrefix = config('api-platform.defaults.route_prefix') ?? '';
    }

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
        $path = Str::plural(Str::kebab($type));

        return sprintf('%s/%s/%s', $this->routePrefix, $path, $id);
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

    // -------------------------------------------------------------------------
    // BOILERPLATE SYMFONY SERIALIZER
    // -------------------------------------------------------------------------

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
