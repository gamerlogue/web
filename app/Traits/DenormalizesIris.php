<?php

namespace App\Traits;

use ApiPlatform\Metadata\IriConverterInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @mixin FormRequest
 */
trait DenormalizesIris
{
    protected function prepareForValidation(): void
    {
        $this->denormalizeIris();

        $parentClass = get_parent_class($this);
        if ($parentClass && method_exists($parentClass, 'prepareForValidation')) {
            parent::prepareForValidation();
        }
    }

    protected function denormalizeIris(): void
    {
        $data = $this->all();
        $modified = false;

        if (isset($data['data']['attributes']) && is_array($data['data']['attributes'])) {
            array_walk_recursive($data['data']['attributes'], function (&$value) {
                if (is_string($value) && Str::startsWith($value, '/api/')) {
                    $value = $this->convertIriToId($value);
                }
            });
            $modified = true;
        }

        if (isset($data['data']['relationships']) && is_array($data['data']['relationships'])) {
            array_walk_recursive($data['data']['relationships'], function (&$value, $key) {
                if ($key === 'id' && is_string($value) && Str::startsWith($value, '/api/')) {
                    $value = $this->convertIriToId($value);
                }
            });
            $modified = true;
        }

        if ($modified) {
            $this->merge($data);
        }
    }

    protected function convertIriToId(string $iri): string|int
    {
        try {
            $resource = app(IriConverterInterface::class)->getResourceFromIri($iri);

            if (method_exists($resource, 'getKey')) {
                return $resource->getKey();
            }

            if (property_exists($resource, 'id')) {
                return $resource->id;
            }
        } catch (\Exception $e) {
            // If conversion fails, return the original IRI
        }

        return $iri;
    }
}
