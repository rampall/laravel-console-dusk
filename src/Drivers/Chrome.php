<?php

declare(strict_types=1);

namespace RamPall\LaravelConsoleDusk\Drivers;

use Closure;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Rampall\Dusk\Chrome\SupportsChrome;
use RamPall\LaravelConsoleDusk\Contracts\Drivers\DriverContract;

class Chrome implements DriverContract
{
    use SupportsChrome;

    public function open(): void
    {
        static::startChromeDriver();
    }

    public function close(): void
    {
        static::stopChromeDriver();
    }

    public static function afterClass(Closure $callback): void
    {
        // ..
    }

    public function getDriver()
    {
        $options = (new ChromeOptions)->addArguments(
            [
                '--disable-gpu',
                //'--headless',
            ]
        );

        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()
                ->setCapability(
                    ChromeOptions::CAPABILITY,
                    $options
                ),90000, 90000
        );
    }

    public function __destruct()
    {
        $this->close();
    }
}
