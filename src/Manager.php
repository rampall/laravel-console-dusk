<?php

declare(strict_types=1);

namespace RamPall\LaravelConsoleDusk;

use Closure;
use Illuminate\Console\Command;
use RamPall\LaravelConsoleDusk\Contracts\ConsoleBrowserFactoryContract;
use RamPall\LaravelConsoleDusk\Contracts\Drivers\DriverContract;
use RamPall\LaravelConsoleDusk\Contracts\ManagerContract;
use RamPall\LaravelConsoleDusk\Drivers\Chrome;

class Manager implements ManagerContract
{
    protected $driver;

    protected $browserFactory;

    public function __construct(DriverContract $driver = null, ConsoleBrowserFactoryContract $browserFactory = null)
    {
        $this->driver = $driver ?: new Chrome();
        $this->browserFactory = $browserFactory ?: new ConsoleBrowserFactory();
    }

    public function browse(Command $command, Closure $callback): void
    {
        $this->driver->open();

        $browser = $this->browserFactory->make($command, $this->driver);

        try {
            $callback($browser);
        } catch (\Throwable $e) {
        }

        $browser->getOriginalBrowser()
            ->quit();

        $this->driver->close();

        if (! empty($e)) {
            throw $e;
        }
    }
}
