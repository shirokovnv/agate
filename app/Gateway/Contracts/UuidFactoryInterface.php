<?php

declare(strict_types=1);

namespace App\Gateway\Contracts;

interface UuidFactoryInterface
{
    public function makeUuid(): string;
}
