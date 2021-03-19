<?php

declare(strict_types=1);

namespace RamPall\LaravelConsoleDusk;

use Illuminate\Console\Command;
use Rampall\Dusk\Browser;
use Rampall\Dusk\Concerns\ProvidesBrowser;
use RamPall\LaravelConsoleDusk\Contracts\ConsoleBrowserContract;
use RamPall\LaravelConsoleDusk\Contracts\ConsoleBrowserFactoryContract;
use RamPall\LaravelConsoleDusk\Contracts\Drivers\DriverContract;

class ConsoleBrowserFactory implements ConsoleBrowserFactoryContract
{
    use ProvidesBrowser;

    protected $driver;

    public function make(Command $command, DriverContract $driver): ConsoleBrowserContract
    {
        $this->driver = $driver;

        return new ConsoleBrowser($command, new Browser($this->createWebDriver()));
    }

    protected function driver()
    {
        return $this->driver->getDriver();
    }
}
