<?php

namespace App\Services\Site;

use App\Models\Task;
use Exception;
use Illuminate\Http\JsonResponse;

class TaskService
{
    /**
     * @param  array  $data
     * @return JsonResponse
     */
    public function store(array $data): JsonResponse
    {
        try {
            Task::query()
                ->create($data);

            return jsonSuccess('The task has been created', 200);
        } catch (Exception $exception) {
            return jsonError($exception->getMessage(), $exception->getCode());
        }
    }
}
