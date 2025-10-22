<?php

namespace App\Modules\Tasks;

use App\Http\Controllers\Controller;
use App\Modules\Tasks\Services\TaskService;
use App\Modules\Tasks\Requests\CreateTaskRequest;
use App\Modules\Tasks\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService,
    ) {}

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Get list of tasks",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index()
    {
        return $this->taskService->get();
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{task_id}",
     *     tags={"Tasks"},
     *     summary="Get a single task",
     *     @OA\Parameter(
     *         name="task_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     */
    public function show($task_id)
    {
        return $this->taskService->find($task_id);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Create a new task",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateTaskRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully"
     *     )
     * )
     */
    public function store(CreateTaskRequest $request)
    {
        return $this->taskService->create($request->validated());
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{task_id}",
     *     tags={"Tasks"},
     *     summary="Update a task",
     *     @OA\Parameter(
     *         name="task_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     */
    public function update(UpdateTaskRequest $request, $task_id)
    {
        return $this->taskService->update($request->validated(), $task_id);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{task_id}",
     *     tags={"Tasks"},
     *     summary="Delete a task",
     *     @OA\Parameter(
     *         name="task_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     */
    public function destroy($task_id)
    {
        return $this->taskService->delete($task_id);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks/{task_id}/complete",
     *     tags={"Tasks"},
     *     summary="Mark a task as complete",
     *     @OA\Parameter(
     *         name="task_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task marked as complete"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     */
    public function complete($task_id)
    {
        return $this->taskService->complete($task_id);
    }
}