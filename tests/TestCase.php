<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (app()->environment('testing')) {
            $database = config('database.connections.mysql.database');

            if ($database !== 'laravel_testing') {
                throw new \RuntimeException(
                    "Banco de testes incorreto: {$database}"
                );
            }
        }
    }
}