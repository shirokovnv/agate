<?php

declare(strict_types=1);

namespace App\Models;

use App\Gateway\Contracts\Schema\ServiceInterface;
use App\Observers\JsonSchemaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $base_url
 */
#[ObservedBy([JsonSchemaObserver::class])]
class Service extends Model implements ServiceInterface
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'base_url',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function getName(): string
    {
        return $this->name;
    }

    public function getBaseUrl(): string
    {
        return $this->base_url;
    }
}
