<?php

declare(strict_types=1);

/**
 * JSON:API has no documentation normalizer: listing it in `docs_formats` routes the request to
 * the Hydra documentation, which the JSON:API serializer cannot normalize (500).
 */
test('the documentation is not offered as json:api', function () {
    $this->get('/api/docs.jsonapi')->assertNotFound();
});

test('the documentation is served as openapi', function () {
    $this->get('/api/docs.jsonopenapi')->assertOk();
});
