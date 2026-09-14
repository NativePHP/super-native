<?php

namespace App\Support;

use App\Enums\ParityDemoMode;
use App\Models\Click;

class ParityDemoService
{
    public function mountSummary(Click $click): string
    {
        return "Container injected for Click #{$click->getRouteKey()}";
    }

    public function actionSummary(Click $click, ParityDemoMode $mode): string
    {
        return "Action resolved Click #{$click->getRouteKey()} + service + {$mode->value} enum";
    }

    public function eventSummary(string $mode, int $count): string
    {
        return "{$mode} event received at count {$count} (listener service injected)";
    }
}
