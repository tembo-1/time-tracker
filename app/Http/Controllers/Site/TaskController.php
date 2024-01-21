<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Task\StoreRequest;
use App\Models\Task;
use App\Services\Site\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @param  StoreRequest  $request
     * @param  TaskService  $service
     * @return JsonResponse
     */
    public function store(StoreRequest $request, TaskService $service): JsonResponse
    {
        $data = $request->validated();

        return $service->store($data);
    }


}
