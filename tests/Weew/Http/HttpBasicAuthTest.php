<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpBasicAuth;

class HttpBasicAuthTest extends PHPUnit_Framework_TestCase {
    public function test_create_basic_auth() {
        $basicAuth = new HttpBasicAuth('foo', 'bar');
        $this->assertEquals('foo', $basicAuth->getUsername());
        $this->assertEquals('bar', $basicAuth->getPassword());
    }

    public function test_getters_and_setters() {
        $basicAuth = new HttpBasicAuth();
        $basicAuth->setUsername('foo');
        $basicAuth->setPassword('bar');
        $this->assertEquals('foo', $basicAuth->getUsername());
        $this->assertEquals('bar', $basicAuth->getPassword());
    }

    public function test_get_basic_auth_token() {
        $basicAuth = new HttpBasicAuth('foo', 'bar');
        $this->assertEquals(
            base64_encode(s('%s:%s', 'foo', 'bar')),
            $basicAuth->getBasicAuthToken()
        );
    }

    public function test_has_basic_auth() {
        $basicAuth = new HttpBasicAuth('foo', 'bar');
        $this->assertTrue($basicAuth->hasBasicAuth());
        $basicAuth->removeBasicAuth();
        $this->assertFalse($basicAuth->hasBasicAuth());
    }

    public function test_to_array() {
        $auth = new HttpBasicAuth('foo', 'bar');
        $this->assertEquals(
            [
                'username' => 'foo',
                'password' => 'bar',
                'token' => $auth->getBasicAuthToken(),
            ],
            $auth->toArray()
        );
    }
}
