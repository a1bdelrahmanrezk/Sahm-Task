<?php

namespace App\Modules\Tasks\Models;

use App\Models\User;
use App\Modules\Tasks\Enums\TaskStatusEnum;
use Database\Factories\TaskFactory;
use Doctrine\Common\Annotations\Annotation\Enum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    // traits
    use HasFactory, SoftDeletes;

    // properties
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    public $incrementing = true;
    public $timestamps = true;
    protected static function newFactory()
    {
        return TaskFactory::new();
    }

    // attributes
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'status'
    ];

    // casts
    protected $casts = [
        'due_date' => 'date',
        'status' => TaskStatusEnum::class,
    ];

    // relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // scopes 
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['status'] ?? null, fn($q, $s) => $q->where('status', $s))
            ->when($filters['due_from'] ?? null, fn($q, $d) => $q->whereDate('due_date', '>=', $d))
            ->when($filters['due_to'] ?? null, fn($q, $d) => $q->whereDate('due_date', '<=', $d));
    }
}
