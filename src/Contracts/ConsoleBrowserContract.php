<?php

declare(strict_types=1);

namespace RamPall\LaravelConsoleDusk\Contracts;

use Rampall\Dusk\Browser;

interface ConsoleBrowserContract
{
    public function inSecret(): ConsoleBrowserContract;

    public function getOriginalBrowser(): Browser;
}
