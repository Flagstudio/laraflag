<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();
        $this->actingAs($user);
        return $this;
    }

    /**
     * Make ajax POST request
     *
     * @param mixed $uri
     */
    protected function ajaxPost($uri, array $data = [])
    {
        return $this->post($uri, $data, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }

    /**
     * Make ajax GET request
     *
     * @param mixed $uri
     */
    protected function ajaxGet($uri, array $data = [])
    {
        return $this->call('GET', $uri, $data, [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }
}
