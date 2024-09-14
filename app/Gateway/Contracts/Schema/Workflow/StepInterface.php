<?php

declare(strict_types=1);

namespace App\Gateway\Contracts\Schema\Workflow;

interface StepInterface
{
    public function getMethod(): string;

    public function getService(): string;

    public function getPath(): string;

    public function getOutKey(): ?string;
}
