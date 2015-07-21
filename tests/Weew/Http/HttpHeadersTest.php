<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpHeaders;

class HttpHeadersTest extends PHPUnit_Framework_TestCase {
    public function test_set_and_get_headers() {
        $headers = new HttpHeaders();

        $headers->set('foo', 'bar');
        $this->assertTrue($headers->has('foo'));
        $this->assertEquals('bar', $headers->get('foo'));
        $this->assertEquals(['foo' => 'bar'], $headers->getAll());

        $headers->remove('foo');
        $this->assertFalse($headers->has('foo'));
        $this->assertNull($headers->get('foo'));
        $this->assertEquals('bar', $headers->get('foo', 'bar'));
    }
}
