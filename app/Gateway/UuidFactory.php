<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Gateway\Contracts\UuidFactoryInterface;
use Illuminate\Support\Str;

class UuidFactory implements UuidFactoryInterface
{
    public function makeUuid(): string
    {
        return Str::uuid()->toString();
    }
}
