<?php

/**
 * The usual json responses of success or failure
 */

use Illuminate\Http\JsonResponse;

if (! function_exists('jsonSuccess')) {
    /**
     * success
     *
     */
    function jsonSuccess(string $message, string|int $code): JsonResponse
    {
        return response()->json([
            'message'   => $message,
            'code'      => $code,
        ]);
    }
}

if (! function_exists('jsonError')) {
    /**
     * failure
     *
     */
    function jsonError(string $message, string|int $code): JsonResponse
    {
        return response()->json([
            'message'   => $message,
            'code'      => $code,
        ], 500);
    }
}
