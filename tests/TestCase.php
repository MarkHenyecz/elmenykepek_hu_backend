<?php

namespace Tests;

use App\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public static function initialize() {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->loadEnvironmentFrom('.env.testing');

        $app->make(Kernel::class)->bootstrap();

        if (config('database.default') == 'sqlite') {
            $process = new Process(["touch", config('database.connections.sqlite.database')]);
            $process->run();
            
            $db = app()->make('db');
            $db->connection()->getPdo()->exec("pragma foreign_keys=1");
        }

        Artisan::call('migrate');
        Artisan::call('db:seed');

        return $app;
    }
}
