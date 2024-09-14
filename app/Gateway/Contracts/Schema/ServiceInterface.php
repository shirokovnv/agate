<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema;

interface ServiceInterface
{
    public function getName(): string;

    public function getBaseUrl(): string;
}
