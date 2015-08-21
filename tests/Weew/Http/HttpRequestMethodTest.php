<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpRequestMethod;

class HttpRequestMethodTest extends PHPUnit_Framework_TestCase {
    public function test_get_methods() {
        $this->assertEquals(
            ['GET', 'POST', 'PUT', 'UPDATE', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'],
            HttpRequestMethod::getMethods()
        );
    }

    public function test_is_valid() {
        foreach (HttpRequestMethod::getMethods() as $method) {
            $this->assertTrue(
                HttpRequestMethod::isValid($method)
            );
        }

        foreach (['foo', 'bar', 'baz'] as $method) {
            $this->assertFalse(
                HttpRequestMethod::isValid($method)
            );
        }
    }
}
