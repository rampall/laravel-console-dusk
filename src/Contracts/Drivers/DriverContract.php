<?php

declare(strict_types=1);

namespace RamPall\LaravelConsoleDusk\Contracts\Drivers;

interface DriverContract
{
    public function open(): void;

    public function close(): void;

    public function getDriver();
}
