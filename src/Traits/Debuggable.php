<?php

namespace Nos\BaseService\Traits;

use Illuminate\Support\Facades\Log;

trait Debuggable
{
    public function debug(string $output): void
    {
        if (!app()->runningInConsole())
        {
            return;
        }

        echo 'Debug: ' . $output . PHP_EOL;

        Log::debug($output);
    }
}
