<?php

namespace App\Ship\Apiato\Abstracts\Tests\PhpUnit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    use DatabaseTransactions;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->fixSqliteDropForeignKey();
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown() : void
    {
        parent::tearDown();
    }
}
