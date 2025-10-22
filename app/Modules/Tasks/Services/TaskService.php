<?php

namespace App\Modules\Tasks\Services;

use App\Modules\Tasks\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Modules\Tasks\Repositories\TaskRepository;

readonly class TaskService
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function get()
    {
        return $this->taskRepository->get();
    }

    public function create($data): Task
    {
        $taskData = $this->constructTaskModel($data);

        $task = $this->taskRepository->create($taskData);

        return $task;
    }



    public function constructTaskModel($data, bool $forUpdate = false): array
    {
        $fields = [
            'title',
            'description',
            'due_date',
            'status'
        ];
        $taskData = [];

        foreach ($fields as $field) {
            $value = $data[$field] ?? null;

            if ($value !== null) {
                $taskData[$field] = $value;
            }
        }

        if (!$forUpdate) {
            $taskData['user_id'] = Auth::user()?->id;
        }

        return $taskData;
    }


    public function update($data, int $id): Task
    {
        $taskData = $this->constructTaskModel($data, true);

        $task = $this->taskRepository->update($taskData, $id);

        return $task;
    }

    public function find($task_id)
    {
        return $this->taskRepository->find($task_id);
    }

    public function complete($task_id)
    {
        return $this->taskRepository->complete($task_id);
    }
    public function delete($task_id)
    {
        return $this->taskRepository->delete($task_id);
    }
}
