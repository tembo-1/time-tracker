<?php

namespace App\Services\Site;

use App\Models\Project;
use Exception;
use Illuminate\Http\JsonResponse;

class ProjectService
{
    /**
     * @param  array  $data
     * @return JsonResponse
     */
    public function store(array $data): JsonResponse
    {
        try {
            Project::query()
                ->create($data);

            return jsonSuccess('The project has been created', 200);
        } catch (Exception $exception) {
            return jsonError($exception->getMessage(), $exception->getCode());

        }
    }
}
