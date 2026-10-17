<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\ApiDomainException;
use App\Models\Activity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

/**
 * Marks library writes as part of an import (the sync of a connected service), named by the
 * client in the X-Library-Import header. Every write of one batch counts into a single
 * library_imported activity instead of producing its own.
 *
 * Context is request-scoped, Octane included.
 */
class LibraryImport
{
    public const string HEADER = 'X-Library-Import';

    public function handle(Request $request, Closure $next): Response
    {
        $batch = $request->header(self::HEADER);
        if ($batch !== null) {
            if (! preg_match('/^[A-Za-z0-9_-]{1,64}$/D', $batch)) {
                // Rendered here: API Platform has not negotiated the JSON:API error format yet.
                return (new ApiDomainException(422, 'invalid_import_batch', 'The import batch must be 1 to 64 letters, digits, "_" or "-".'))->render();
            }
            Context::add(Activity::IMPORT_CONTEXT, $batch);
        }

        return $next($request);
    }
}
