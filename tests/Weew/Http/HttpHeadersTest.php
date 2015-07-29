<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpHeaders;

class HttpHeadersTest extends PHPUnit_Framework_TestCase {
    public function test_getters_and_setters() {
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

    public function test_to_array() {
        $headers = new HttpHeaders(['foo' => 'bar', 'yolo' => 'swag']);

        $this->assertEquals(
            ['foo' => 'bar', 'yolo' => 'swag'], $headers->toArray()
        );
    }

    public function test_getters_and_setters_without_replace() {
        $headers = new HttpHeaders(['foo' => 'bar']);
        $headers->set('foo', 'baz', false);
        $this->assertEquals(['foo' => 'baz'], $headers->getAll());
        $this->assertEquals(['foo' => ['bar', 'baz']], $headers->getAll(false));
        $this->assertEquals('baz', $headers->get('foo'));
        $this->assertEquals('bar', $headers->get('foo.0'));
        $this->assertEquals(['bar', 'baz'], $headers->get('foo', null, false));
    }
}
