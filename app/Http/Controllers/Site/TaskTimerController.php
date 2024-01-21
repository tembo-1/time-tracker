<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\TaskTimer\PutRequest;
use App\Http\Requests\Site\TaskTimer\StoreRequest;
use App\Models\TaskTimer;
use App\Services\Site\TaskTimerService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskTimerController extends Controller
{
    /**
     * @param  StoreRequest  $request
     * @param  TaskTimerService  $service
     * @return JsonResponse
     */
    public function store(StoreRequest $request, TaskTimerService $service): JsonResponse
    {
        $data = $request->validated();

        return $service->store($data);
    }

    /**
     * @param  PutRequest  $request
     * @param  TaskTimerService  $service
     * @return JsonResponse
     */
    public function update(PutRequest $request, TaskTimerService $service): JsonResponse
    {
        $data = $request->validated();

        return $service->update($data);
    }
}
