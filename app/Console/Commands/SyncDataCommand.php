<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncDataCommand extends Command
{
    protected $signature = 'sync:data';

    protected $description = 'Background sync task (runs via WorkManager)';

    public function handle(): int
    {
        logger('sync:data fired at ' . now()->toDateTimeString());

        return self::SUCCESS;
    }
}