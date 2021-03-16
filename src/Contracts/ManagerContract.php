<?php

declare(strict_types=1);

namespace RamPall\LaravelConsoleDusk\Contracts;

use Closure;
use Illuminate\Console\Command;

interface ManagerContract
{
    public function browse(Command $command, Closure $callback): void;
}
