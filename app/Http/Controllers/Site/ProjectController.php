<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Project\StoreRequest;
use App\Models\Project;
use App\Services\Site\ProjectService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @param  StoreRequest  $request
     * @param  ProjectService  $service
     * @return JsonResponse
     */
    public function store(StoreRequest $request, ProjectService $service): JsonResponse
    {
        $data = $request->validated();

        return $service->store($data);
    }
}
