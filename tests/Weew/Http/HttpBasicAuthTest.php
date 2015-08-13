<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\BasicAuthParser;
use Weew\Http\HttpBasicAuth;
use Weew\Http\HttpHeaders;

class HttpBasicAuthTest extends PHPUnit_Framework_TestCase {
    public function test_get_username() {
        $headers = new HttpHeaders();
        $auth = new HttpBasicAuth($headers);
        $parser = new BasicAuthParser();
        $parser->setUsername($headers, 'foo');

        $this->assertEquals(
            'foo', $auth->getUsername()
        );
    }

    public function test_get_password() {
        $headers = new HttpHeaders();
        $auth = new HttpBasicAuth($headers);
        $parser = new BasicAuthParser();
        $parser->setPassword($headers, 'bar');

        $this->assertEquals(
            'bar', $auth->getPassword()
        );
    }

    public function test_set_username() {
        $auth = new HttpBasicAuth(new HttpHeaders());

        $auth->setUsername('foo');
        $this->assertEquals('foo', $auth->getUsername());
    }

    public function test_set_password() {
        $auth = new HttpBasicAuth(new HttpHeaders());

        $auth->setPassword('bar');
        $this->assertEquals('bar', $auth->getPassword());
    }

    public function test_get_token() {
        $headers = new HttpHeaders();
        $auth = new HttpBasicAuth($headers);
        $parser = new BasicAuthParser();

        $parser->setToken($headers, 'foo');
        $this->assertEquals('foo', $auth->getToken());
    }

    public function test_set_token() {
        $auth = new HttpBasicAuth(new HttpHeaders());

        $auth->setToken('foo');
        $this->assertEquals('foo', $auth->getToken());;
    }

    public function test_has_basic_auth() {
        $auth = new HttpBasicAuth(new HttpHeaders());

        $this->assertFalse($auth->hasBasicAuth());
        $auth->setUsername('foo');
        $this->assertTrue($auth->hasBasicAuth());
    }

    public function test_create_with_credentials() {
        $auth = new HttpBasicAuth(new HttpHeaders(), 'foo', 'bar');
        $this->assertTrue($auth->hasBasicAuth());
        $this->assertEquals('foo', $auth->getUsername());
        $this->assertEquals('bar', $auth->getPassword());
    }

    public function test_to_array() {
        $auth = new HttpBasicAuth(new HttpHeaders(), 'foo', 'bar');

        $this->assertEquals(
            [
                'username' => $auth->getUsername(),
                'password' => $auth->getPassword(),
                'token' => $auth->getToken(),
            ],
            $auth->toArray()
        );
    }
}
