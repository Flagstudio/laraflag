<?php

namespace App\Ship\Apiato\Abstracts\Tests\PhpUnit;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\SQLiteBuilder;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Fluent;
use Illuminate\Testing\TestResponse;
use Tests\CreatesApplication;
use Tests\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    use CreatesApplication,
        DatabaseTransactions;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->fixSqliteDropForeignKey();
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }

    protected function ajaxPost($uri, array $data = []): TestResponse
    {
        return $this->post($uri, $data, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }

    protected function ajaxGet($uri, array $data = []): TestResponse
    {
        return $this->call('GET', $uri, $data, [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }

    public function fixSqliteDropForeignKey()
    {
        \Illuminate\Database\Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config) {
            return new class($connection, $database, $prefix, $config) extends SQLiteConnection {
                public function getSchemaBuilder()
                {
                    if ($this->schemaGrammar === null) {
                        $this->useDefaultSchemaGrammar();
                    }
                    return new class($this) extends SQLiteBuilder {
                        protected function createBlueprint($table, Closure $callback = null)
                        {
                            return new class($table, $callback) extends Blueprint {
                                public function dropForeign($index)
                                {
                                    return new Fluent();
                                }
                            };
                        }
                    };
                }
            };
        });
    }
}
