<?php

namespace App\Modules\Tasks\Repositories;

use App\Modules\Shared\Repositories\BaseRepository;
use App\Modules\Tasks\Enums\TaskStatusEnum;
use App\Modules\Tasks\Events\TaskCompletedEvent;
use App\Modules\Tasks\Models\Task;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function complete($task_id)
    {
        $task = $this->find($task_id);
        $task->status = TaskStatusEnum::DONE->value;
        $task->save();
        event(new TaskCompletedEvent($task));
        return $task;
    }
}
