<?php

declare(strict_types=1);

namespace App\Models;

use App\Gateway\Contracts\Schema\ActionInterface;
use App\Models\Casts\WorkflowJsonCast;
use App\Observers\JsonSchemaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $method
 * @property string $pattern
 * @property int $priority
 * @property array workflows
 */
#[ObservedBy([JsonSchemaObserver::class])]
class Action extends Model implements ActionInterface
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'method',
        'pattern',
        'priority',
        'workflows',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'workflows' => WorkflowJsonCast::class,
    ];

    protected function method(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getWorkflows(): array
    {
        return $this->workflows;
    }
}
