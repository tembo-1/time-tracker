<?php

namespace App\Services\Site;

use App\Models\TaskTimer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;

class TaskTimerService
{
    /**
     * @param  array  $data
     * @return JsonResponse
     */
    public function store(array $data): JsonResponse
    {
        try {
            TaskTimer::query()
                ->create($this->prepareStore($data));

            return jsonSuccess('The timer is running!', 200);
        } catch (Exception $exception) {
            return jsonError($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param  array  $data
     * @return JsonResponse
     */
    public function update(array $data): JsonResponse
    {
        try {
            if (!$this->checkOnEnd($data['task_id'])) {
                throw new Exception('The timer has already been stopped or there is no such task', 406);
            }

            TaskTimer::query()
                ->find($data['task_id'])
                ->update([
                    'end' => Carbon::now(),
                ]);

            return jsonSuccess('The timer is stopped', 200);
        } catch (Exception $exception) {
            return jsonError($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param  array  $data
     * @return array
     */
    private function prepareStore(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    /**
     * @param  int  $timer
     * @return bool
     */
    private function checkOnEnd(int $timer): bool
    {
        if (TaskTimer::find($timer) && !TaskTimer::find($timer)->end) {
            return true;
        }

        return false;
    }
}
