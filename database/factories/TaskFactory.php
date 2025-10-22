<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Tasks\Models\Task;
use App\Modules\Tasks\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Tasks\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph(),
            'due_date' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(TaskStatusEnum::values()),
        ];
    }
}
