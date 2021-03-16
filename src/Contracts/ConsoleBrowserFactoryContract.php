<?php

declare(strict_types=1);

namespace RamPall\LaravelConsoleDusk\Contracts;

use Illuminate\Console\Command;
use RamPall\LaravelConsoleDusk\Contracts\Drivers\DriverContract;

interface ConsoleBrowserFactoryContract
{
    public function make(Command $command, DriverContract $driver): ConsoleBrowserContract;
}
