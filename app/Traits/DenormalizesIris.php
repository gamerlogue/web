<?php

declare(strict_types=1);

namespace App\Traits;

use ApiPlatform\Metadata\Exception\InvalidArgumentException;
use ApiPlatform\Metadata\Exception\ItemNotFoundException;
use ApiPlatform\Metadata\IriConverterInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @mixin FormRequest
 */
trait DenormalizesIris
{
    protected function denormalizeIris(): void
    {
        $data = $this->all();

        if (! isset($data['data']['relationships']) || ! is_array($data['data']['relationships'])) {
            return;
        }

        array_walk_recursive($data['data']['relationships'], function (&$value, $key): void {
            if ($key === 'id' && is_string($value) && Str::startsWith($value, '/api/')) {
                $value = $this->convertIriToId($value);
            }
        });

        $this->replace($data);
    }

    protected function convertIriToId(string $iri): string|int
    {
        try {
            $resource = app(IriConverterInterface::class)->getResourceFromIri($iri);
        } catch (InvalidArgumentException|ItemNotFoundException) {
            return $iri;
        }

        if (method_exists($resource, 'getKey')) {
            return $resource->getKey();
        }

        return property_exists($resource, 'id') ? $resource->id : $iri;
    }
}
